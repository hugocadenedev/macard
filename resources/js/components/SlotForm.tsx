import * as React from 'react';
import ReactDOM from 'react-dom';
import FullCalendar, { ClassNamesGenerator, DateSelectArg, DayCellContentArg, EventInput } from '@fullcalendar/react';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin, { DateClickArg } from "@fullcalendar/interaction";
import Axios, { AxiosResponse } from 'axios';
import Booker from './Booker';
import moment from 'moment';

declare var sites, car, slots, $;

export interface ISlotFormProps {
}

export interface ISlotFormState {
  [arg: string]: any
  siteId: any
  amount: number
  slots: any
  selectedSlot: any
}

class SlotForm extends React.Component<ISlotFormProps, ISlotFormState> {
  constructor(props: ISlotFormProps) {
    super(props);

    this.state = {
      siteId: sites.length > 0 ? sites[0].id : null,
      amount: 1,
      slots: slots,
      selectedSlot: null
    }
  }

  buildCalendarEvent(slot: any): EventInput {
    return {
      id: slot.id.toString(),
      title: `${slot.available_amount} disponible`,
      start: slot.start,
      end: slot.endAt,
    }
  }

  deleteSlot = async (slot) => {
    let response: AxiosResponse = await Axios.delete("/api/slots/" + slot.id);
    this.setState({ slots: this.state.slots.filter(s => s.id !== slot.id) })
  }

  select = async (e: DateSelectArg) => {
    let slot = {
      start: e.start,
      end: e.end,
      site_id: this.state.siteId,
      available_amount: this.state.amount,
      car_id: car.id
    }
    let response: AxiosResponse = await Axios.post("/api/slots", slot);
    this.setState({ slots: [...this.state.slots, response.data] });
  }

  eventClick = async (e) => {
    console.log(e)
    let slot = this.state.slots.find(s => s.id.toString() === e.event._def.publicId);
    this.setState({ selectedSlot: slot }, () => $("#slot-modal").modal({ show: true }));
  }

  handleChange = (e: any) => {
    const { name, value } = e.target;
    this.setState({ [name]: value })
  }

  handleSiteChange = async (e) => {
    this.handleChange(e);
    let response: AxiosResponse = await Axios.get("/api/slots?car_id=" + car.id + "&site_id=" + e.target.value);
    this.setState({ slots: response.data });
  }

  public render() {
    console.log(this.state)
    return (
      <div>
        <div className="row mb-3">
          <div className="col-9">
            <div className="row-flex">
              <h5 style={{whiteSpace: "nowrap"}} className="mb-0 mr-2">Créneaux pour </h5>
              <select onChange={this.handleSiteChange} value={this.state.siteId} name="siteId" className="form-control">
              { sites.map(site => (
                <option key={site.id} value={site.id}>{site.name}</option>
              ))}
              </select>
            </div>
          </div>
          <div className="col-3">
            <div className="row-flex">
              <label style={{whiteSpace: "nowrap"}} className="mb-0 mr-2" htmlFor="description">Nombre Disponible</label>
              <input onChange={ this.handleChange } value={ this.state.amount } className="form-control" type="number" name="amount" />
            </div>
          </div>
        </div>
        <div>
          <FullCalendar
            plugins={ [timeGridPlugin, interactionPlugin] }
            headerToolbar={ {
              left: "prev",
              center: "title",
              end: "next",
            } }
            events={ this.state.slots.map((slot) => this.buildCalendarEvent(slot)) }
            select={this.select}
            eventClick={this.eventClick}
            slotMinTime={"08:00:00"}
            slotMaxTime={ "19:00:00" }
            contentHeight={"630px"}
            allDaySlot={false}
            selectable
            locale={"fr"}
          />
        </div>
        <div id="slot-modal" className={"modal"}>
          <div className="modal-dialog">
            { this.state.selectedSlot && <div className="modal-content">
              <div className="modal-header">
                <h5 className="modal-title">{ "Créneau du " + moment(this.state.selectedSlot.start).format("dddd D MMMM à HH[h]mm")}</h5>
                <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div className="modal-body">
                { this.state.selectedSlot.site && <div className="mb-2">
                  {"Site : " + this.state.selectedSlot.site.firstname + " " + this.state.selectedSlot.site.lastname}
                </div>}
                <div>{ "Voiture disponible : " + this.state.selectedSlot.available_amount}</div>
              </div>
              <div className="modal-footer">
                <button data-dismiss="modal" onClick={() => this.deleteSlot(this.state.selectedSlot)} type="button" className="btn btn-danger">Supprimer</button>
              </div>
            </div>}
          </div>
        </div>
      </div>
    );
  }
}

export default SlotForm;


if (document.getElementById('slot-form')) {
  ReactDOM.render(<SlotForm/>, document.getElementById('slot-form'));
}