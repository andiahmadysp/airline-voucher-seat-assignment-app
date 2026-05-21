const PageHeader = ({ title, subtitle }) => {
  return (
    <div className="page-header">
      <h1>{title}</h1>
      <p className="subtitle">{subtitle}</p>
    </div>
  );
};

export default PageHeader;
