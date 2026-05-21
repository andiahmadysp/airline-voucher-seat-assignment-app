import { formatDate } from '../../utils/date.js';

const SeatResult = ({ seats, data }) => {
  return (
    <div className="result">
      <div className="result-head">
        <span className="result-label">Assigned Seats</span>
        <span className="result-label">{data.flightNumber} · {formatDate(data.date)}</span>
      </div>
      <div className="result-body">
        <div className="seats">
          {seats.map((seat) => (
            <div key={seat} className="seat">{seat}</div>
          ))}
        </div>
        <dl className="meta">
          <div><dt>Aircraft</dt><dd>{data.aircraft}</dd></div>
          <div><dt>Flight</dt><dd>{data.flightNumber}</dd></div>
          <div><dt>Date</dt><dd>{formatDate(data.date)}</dd></div>
          <div><dt>Crew</dt><dd>{data.name} · {data.id}</dd></div>
        </dl>
      </div>
    </div>
  );
};

export default SeatResult;
