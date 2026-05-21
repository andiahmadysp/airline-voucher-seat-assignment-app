import client from './client.js';

export const check = (flightNumber, date) =>
  client.post('/check', { flightNumber, date });

export const generate = (payload) =>
  client.post('/generate', payload);
