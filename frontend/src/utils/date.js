export const toIso = (date) => {
  if (!date) return '';
  if (date instanceof Date) return date.toISOString().split('T')[0];
  return date;
};

export const isValidDate = (iso) => {
  if (!iso) return false;
  return !isNaN(new Date(iso).getTime());
};

export const formatDate = (iso) => {
  if (!iso) return '';
  const [y, m, d] = iso.split('-');
  return `${d}-${m}-${y}`;
};
