import Field from '../ui/Field.jsx';
import Button from '../ui/Button.jsx';
import { AIRCRAFT_OPTIONS } from '../../constants/aircraft.js';

const VoucherForm = ({ onSubmit, onReset, loading }) => {
  const handleSubmit = (e) => {
    e.preventDefault();
    const fd = new FormData(e.target);
    onSubmit({
      name: fd.get('name')?.trim(),
      id: fd.get('crewId')?.trim(),
      flightNumber: fd.get('flightNumber')?.trim().toUpperCase(),
      date: fd.get('date'),
      aircraft: fd.get('aircraft'),
    });
  };

  return (
    <form id="form" onSubmit={handleSubmit} onReset={onReset} autoComplete="off" noValidate>
      <div className="grid">
        <Field name="name" label="Crew Name" type="text" required />
        <Field name="crewId" label="Crew ID" type="text" required />
        <Field name="flightNumber" label="Flight Number" hint="e.g. GA102" type="text" placeholder="GA102" required />
        <Field name="date" label="Flight Date" type="date" required />
        <Field name="aircraft" label="Aircraft Type" type="select" size="full" required options={AIRCRAFT_OPTIONS} />
      </div>
      <div className="actions">
        <Button variant="ghost" type="reset">Clear</Button>
        <Button variant="primary" type="submit" loading={loading}>
          {loading ? 'Generating…' : 'Generate Vouchers'}
        </Button>
      </div>
    </form>
  );
};

export default VoucherForm;
