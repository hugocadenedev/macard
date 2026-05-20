export default class Slot {

  public id: any
  public start: Date;
  public commercial: any;
  public available: boolean;

  constructor(json) {
    this.id = json.id;
    this.start = json.start && new Date(json.start);
    this.commercial = json.commercial;
    this.available = json.available;
  }

}