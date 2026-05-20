import moment from 'moment';
import * as React from 'react';
import Slot from '../slot';

export interface ISlotShowProps {
  onSelectSlot: (arg: Slot) => void
  slots: Slot[]
  selectedCar: any
  selectedDay: any
  selectedSite: any
  selectedSlot: any
}

export interface ISlotShowState {
}

export default class SlotShow extends React.Component<ISlotShowProps, ISlotShowState> {
  constructor(props: ISlotShowProps) {
    super(props);

    this.state = {
    }
  }

  public render() {
    const { onSelectSlot, selectedCar, selectedDay, selectedSite, selectedSlot, slots} = this.props
      if (selectedCar && selectedDay && selectedSite) return <div>
        <h5>
          Créneaux disponibles pour {selectedSite.name}
        </h5>
        <div className="row">
          { slots.map(slot => {
            return <div key={slot.id + "slot"} className="col-4 mb-3">
              <div onClick={ () => onSelectSlot(slot) } className={ "booking" + (slot.available ? " free" : "") + (slot === selectedSlot ? " selected" : "") }>
                { moment(slot.start).format("HH:mm") }
              </div>
            </div>
          }) }
        </div>
      </div>
      return <div style={{fontSize: "1.2rem"}} className="text-center p-3">
        Sélectionnez un véhicule et une date pour voir les créneaux disponible
      </div>
  }
}
