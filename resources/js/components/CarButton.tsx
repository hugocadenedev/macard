import * as React from 'react';

export interface ICarButtonProps {
  car: any
  onClick: () => void
  selected: boolean
}

export interface ICarButtonState {
}

export default class CarButton extends React.Component<any, ICarButtonState> {

  getImageStyle(): React.CSSProperties {
    const { car } = this.props;
    return {
      backgroundImage: "url(" + car.image_url + ")",
      backgroundPosition: "center",
      backgroundSize: "cover",
      height: "100px"
    }
  }

  public render() {
    const { car, onClick, selected } = this.props;
    return (
      <div className={"car-btn" + (selected ? " selected" : "")} onClick={ onClick } >
        <div style={this.getImageStyle()} className="car-img">

        </div>
        <div className="text-center">
          { car.model}
        </div>
      </div>
    );
  }
}
