import Spinner from './Spinner.jsx';

const Button = ({ variant = 'primary', loading = false, children, disabled, ...args }) => {
  return (
    <button
      className={`btn btn-${variant}`}
      disabled={disabled || loading}
      {...args}
    >
      {loading && <Spinner size={14} />}
      {children}
    </button>
  );
};

export default Button;
