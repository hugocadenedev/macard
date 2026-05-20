import * as React from 'react';

export interface ISiteButtonProps {
  site: any
  onClick: () => void
  selected: boolean
}

export interface ISiteButtonState {
}

export default class SiteButton extends React.Component<any, ISiteButtonState> {



  public render() {
    const { site, onClick, selected } = this.props;
    return (
      <div className={"site-btn" + (selected ? " selected" : "")} onClick={ onClick } >
        <div className="text-center">
          <div className="site-name">
            { site.name}
          </div>
          <div className="divider"></div>
          <div className="site-address">
            <div>
              { site.address }
            </div>
            {site.address_name && <div>
              { site.address_name }
            </div>}
            <div>
              <span>{ site.cp} </span>
              <span>{ site.city}</span>
            </div>
          </div>
        </div>
      </div>
    );
  }
}
