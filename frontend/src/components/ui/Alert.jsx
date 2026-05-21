const ICON_WARN = (
  <svg className="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true">
    <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
    <line x1="12" y1="9" x2="12" y2="13"/>
    <line x1="12" y1="17" x2="12.01" y2="17"/>
  </svg>
);

const ICON_CHECK = (
  <svg className="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.2" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true">
    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
    <polyline points="22 4 12 14.01 9 11.01"/>
  </svg>
);

const Alert = ({ variant = 'danger', title, messages, children }) => {
  return (
    <div className={`alert ${variant}`} role={variant === 'danger' ? 'alert' : 'status'}>
      {variant === 'danger' ? ICON_WARN : ICON_CHECK}
      <div className="body">
        <div className="title">{title}</div>
        {messages && (
          messages.length === 1
            ? <div>{messages[0]}</div>
            : <ul>{messages.map((m, i) => <li key={i}>{m}</li>)}</ul>
        )}
        {children}
      </div>
    </div>
  );
};

export default Alert;
