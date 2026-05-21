import PageHeader from "./components/PageHeader.jsx";
import Field from "./components/Field.jsx";
import Button from "./components/Button.jsx";
import {AIRCRAFT_OPTIONS} from "./constants/aircraft.js";

function App() {




    return (<main className={'container'}>
        <PageHeader title={'Voucher Assignment'} subtitle={'Generate 3 unique seats for voucher winners on a flight.'}/>

        <form id={"form"}>
            <div className="grid">
                <Field name={'name'} label={'Crew Name'} type={'text'} required={true}/>
                <Field name={'crewId'} label={'Crew ID'} type={'text'} required={true}/>
                <Field name={'flightNumber'} hint={'e.g. GA102'} label={'Flight Number'} type={'text'} required={true}/>
                <Field name={'date'} label={'Flight Date'} type={'date'} required={true}/>
                <Field name={'aircraft'} label={'Aircraft Type'} size={'full'} type={'select'} required={true} options={AIRCRAFT_OPTIONS}/>
            </div>

            <div className="actions">
                <Button variant={'ghost'} type={'reset'}>Reset</Button>
                <Button variant={'primary'} type={'submit'}>Generate Vouchers</Button>
            </div>
        </form>
    </main>)
}

export default App
