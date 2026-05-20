import React from 'react';
import ReactDOM from 'react-dom';
import FullCalendar, { ClassNamesGenerator, DayCellContentArg } from '@fullcalendar/react';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin, { DateClickArg } from "@fullcalendar/interaction";
import moment from 'moment';
import CarButton from './CarButton';
import Axios from 'axios';
import Slot from '../slot';
import BookingBySlot from '../BookingBySlot';
import SiteButton from './SiteButton';
import SlotShow from './SlotShow';

declare let cars;
declare let token;
declare let sites;
declare let page;

class Booker extends React.Component<any, { selectedCar: any, selectedDay: Date, selectedSlot: Slot, selectedSite: any, bookingTypeId: any, bookingTypes: any[] }> {

  constructor(props) {
    super(props)

    this.state = {
      selectedCar: null,
      selectedDay: null,
      selectedSlot: null,
      selectedSite: null,
      bookingTypeId: 1,
      bookingTypes: []
    }
  }

  public bookingsBySlot: BookingBySlot[];
  public slots = []

  componentDidMount() {
    if (cars.length === 1) {
      this.setState({ selectedCar: cars[0] }, () => this.loadBookings());
    }
    if (sites.length === 1) {
      this.setState({ selectedSite: sites[0] });
    }
    this.loadBookingTypes();
    // window.addEventListener('scroll', this.handleScroll);
  }

  componentWillUnmount() {
    // window.removeEventListener('scroll', this.handleScroll);
  }

  // handleScroll = (e) => {
  //   let scrollTop = e.srcElement.body.scrollTop
  //   if (scrollTop > 450) document.getElementById("booker-card").className = "card focused"
  //   else                 document.getElementById("booker-card").className = "card"
  // }

  async loadBookingTypes() {
    let response = await Axios.get("/api/booking_types");
    this.setState({bookingTypes: response.data})
  }

  loadBookings = async () => {
    const { selectedCar, selectedSite } = this.state
    let response = await Axios.get("/api/slots?car_id=" + selectedCar.id + "&site_id=" + selectedSite.id)
    this.slots = response.data.map(d => new Slot(d));
    this.setState({})

  }

  onCarSelect = (car) => {
    this.setState({selectedCar: car}, () => this.loadBookings())
  }

  onSiteSelect = (site) => {
    this.setState({selectedSite: site}, () => this.loadBookings())
  }

  buildConfirmMessage = () => {
    const { selectedCar, selectedDay, selectedSlot } = this.state
    return `Vous allez réserver pour le ${moment(selectedSlot.start).format("dddd D MMMM à HH[h]mm")}.`;
  }

  onDateClick = (e: DateClickArg) => {
    if (e.date < moment().subtract(1, "day").toDate()) return;
    let selectedDay = e.date;
    this.setState({selectedDay})
  }

  getSelectedDaySlots = () => {
    return this.slots?.filter((slot) => moment(this.state.selectedDay).isSame(moment(slot.start), "day"));
  }

  selectSlot = (slot) => {
    if (this.state.selectedSlot === slot || !slot.available) return;
    this.setState({selectedSlot: slot})
  }

  public dayCellClassNames = (arg) => {
    let className = ""
    let hasEvent = this.slots.find(slot => moment(slot.start).isSame(moment(arg.date), "day")) !== undefined
    if (hasEvent) className += " has-event";
    if (arg.isPast) className += " bg-light";
    return className
  }

  render() {
    const { selectedCar, selectedDay, selectedSlot, selectedSite, bookingTypes, bookingTypeId } = this.state
    return (
      <div className="booking-container">
        { sites.length > 1 && <div className="sites container">
          <h3 style={{color: page.text_color}} className="text-center mb-4">CHOISISSEZ UN CONCESSIONNAIRE</h3>
          <div className="row mb-4">
            { sites.map((site: any) => <div key={site.id} className="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
              <SiteButton selected={selectedSite?.id === site.id} site={site} onClick={() => this.onSiteSelect(site)} />
            </div>) }
          </div>
        </div>}
        <form action="/bookings" method="post">
          <div id="booker-card" className="card mt-5">
            <div className="card-body">
              <div>
                <div className="row mb-4">
                  { cars.map((car: any) => <div key={car.id + "car"} className="col-12 col-sm-6 col-lg-4">
                    <CarButton selected={ selectedCar?.id === car.id } car={ car } onClick={ () => this.onCarSelect(car) } />
                  </div>) }
                </div>
                <div className="row justify-content-center">
                  <div className="d-md-none d-block">
                    <div className="col-12 col-md-4 pt-2">
                      <div  style={{borderTop: "2px solid #f3f5f9"}}>
                        <SlotShow onSelectSlot={ this.selectSlot } slots={ this.getSelectedDaySlots() } selectedSite={ selectedSite } selectedCar={ selectedCar } selectedDay={ selectedDay } selectedSlot={ selectedSlot } />
                      </div>
                    </div>
                  </div>
                  <div className="col-12 col-md-8 mb-3">
                    <FullCalendar
                      plugins={ [dayGridPlugin, interactionPlugin] }
                      headerToolbar={ {
                        left: "prev",
                        center: "title",
                        end: "next",
                      } }
                      dayCellClassNames={ (dayCellClassNames) => this.dayCellClassNames(dayCellClassNames) }
                      dateClick={ this.onDateClick }
                      selectable
                      contentHeight={"calc(15vw + 300px)"}
                      locale={"fr"}
                    />
                  </div>
                  <div className="col-12 col-md-4 pt-2">
                    <h5>
                      Sélectionnez le type de rendez-vous
                    </h5>
                    <div className="mb-4">
                      { bookingTypes.map(type =>
                      <div className="form-check">
                        <input placeholder="Prénom" id={type.id} onChange={() => this.setState({bookingTypeId: type.id})} name="booking_type_id" value={type.id} className="form-check-input" type="radio" checked={type.id == bookingTypeId} />
                        <label className="form-check-label" htmlFor={type.id}>{type.label}</label>
                      </div>
                      )}
                    </div>
                    <h5>
                      Vos informations
                    </h5>
                    <div className="mb-4">
                      <div className="form-group">
                        <input placeholder="Prénom" name="firstname" className="form-control" type="text" required/>
                      </div>
                      <div className="form-group">
                        <input placeholder="Nom" name="lastname" className="form-control" type="text" required/>
                      </div>
                      <div className="form-group">
                        <input placeholder="Email" name="email" className="form-control" type="email" required/>
                      </div>
                      <div className="form-group">
                        <input placeholder="Téléphone" name="phone" className="form-control" type="text"/>
                      </div>
                      <input type="hidden" name="slot_id" value={ selectedSlot?.id } required/>
                      <input type="hidden" name="_token" value={ token }/>
                      <input type="hidden" name="car_id" value={ selectedCar?.id }/>
                    </div>
                    <div className="d-none d-md-block">
                      <SlotShow onSelectSlot={this.selectSlot} slots={this.getSelectedDaySlots()} selectedSite={selectedSite} selectedCar={selectedCar} selectedDay={selectedDay} selectedSlot={selectedSlot} />
                    </div>
                  </div>
                </div>
                { (selectedCar && selectedDay && selectedSlot) && <div className="py-3">
                  <div className="confirm-message">
                    {this.buildConfirmMessage()}
                  </div>
                </div>}
                <div className="card-footer text-center">
                  <button disabled={!selectedSlot || !selectedCar} type="submit" className="btn btn-primary">Réserver</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    );
  }
}

export default Booker;

if (document.getElementById('Booker')) {
  ReactDOM.render(<Booker />, document.getElementById('Booker'));
}
