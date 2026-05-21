import { useState } from 'react';
import { check, generate } from '../api/voucher.js';
import { formatDate } from '../utils/date.js';

const FLIGHT_RE = /^[A-Z]{2}\d{1,4}$/;

const validate = (data) => {
  const errors = [];
  if (!data.name) errors.push('Crew Name is required.');
  if (!data.id) errors.push('Crew ID is required.');
  if (!data.flightNumber) {
    errors.push('Flight Number is required.');
  } else if (!FLIGHT_RE.test(data.flightNumber)) {
    errors.push('Flight Number must be 2 letters followed by 1–4 digits (e.g. GA102).');
  }
  if (!data.date) errors.push('Flight Date is required.');
  if (!data.aircraft) errors.push('Aircraft Type is required.');
  return errors;
};

export const useVoucher = () => {
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const [result, setResult] = useState(null);

  const reset = () => {
    setError(null);
    setResult(null);
  };

  const submit = async (data) => {
    const validationErrors = validate(data);
    if (validationErrors.length) {
      setError({ title: 'Invalid input', messages: validationErrors });
      return;
    }

    setLoading(true);
    setError(null);
    setResult(null);

    try {
      const checkRes = await check(data.flightNumber, data.date);
      if (checkRes.data.exists) {
        setError({
          title: 'Vouchers already generated',
          messages: [
            `Flight ${data.flightNumber} on ${formatDate(data.date)} already has voucher seats assigned. Each flight + date can only be assigned once.`,
          ],
        });
        return;
      }

      const genRes = await generate(data);
      setResult({ seats: genRes.data.seats, data });
    } catch (err) {
      const apiErrors = err.response?.data?.errors;
      if (apiErrors) {
        setError({ title: 'Invalid input', messages: Object.values(apiErrors).flat() });
      } else {
        const msg = err.response?.data?.message ?? 'Something went wrong. Please try again.';
        setError({ title: 'Error', messages: [msg] });
      }
    } finally {
      setLoading(false);
    }
  };

  return { loading, error, result, submit, reset };
};
