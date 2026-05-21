import Topbar from './components/ui/Topbar.jsx';
import PageHeader from './components/ui/PageHeader.jsx';
import Alert from './components/ui/Alert.jsx';
import VoucherForm from './components/voucher/VoucherForm.jsx';
import SeatResult from './components/voucher/SeatResult.jsx';
import { useVoucher } from './hooks/useVoucher.js';
import { formatDate } from './utils/date.js';

function App() {
  const { loading, error, result, submit, reset } = useVoucher();

  return (
    <>
      <Topbar />
      <main className="container">
        <PageHeader
          title="New voucher assignment"
          subtitle="Generate 3 unique seats for voucher winners on a flight."
        />

        <VoucherForm onSubmit={submit} onReset={reset} loading={loading} />

        <div id="feedback">
          {error && (
            <Alert variant="danger" title={error.title} messages={error.messages} />
          )}
          {result && (
            <>
              <Alert variant="success" title="Vouchers generated successfully">
                <div>
                  3 seats assigned for flight <strong>{result.data.flightNumber}</strong> on <strong>{formatDate(result.data.date)}</strong>.
                </div>
              </Alert>
              <SeatResult seats={result.seats} data={result.data} />
            </>
          )}
        </div>
      </main>
    </>
  );
}

export default App;
