import moment from 'moment';
export default class BookingBySlot {

  public amount: number
  public startAt: Date
  public carId: number

  constructor(json) {
    this.amount = json.amount
    this.startAt = new Date(json.start_at)
    this.carId = json.car_id
  }
}