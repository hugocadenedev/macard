import * as React from 'react';
import ReactDOM from 'react-dom';
import ColumnSettings from './ColumnSettings';

export interface IBuilderProps {
}

export interface IBuilderState {
}

export default class Builder extends React.Component<IBuilderProps, IBuilderState> {

  public rows = [{
    order: 1,
    style: {},
    columns: [
      {
        order: 1,
        size: 6,
        style: {},
        elements: []
      },
      {
        order: 2,
        size: 6,
        style: {},
        elements: [
          {
            type: "h3",
            innerHtml: "Salut les totos",
            style: {},
            order: 1
          }
        ]
      }
    ]
  },{
    order: 2,
    style: {},
    columns: [
      {
        order: 1,
        size: 6,
        style: {},
        elements: [
          {
            type: "p",
            innerHtml: "Coucou tutu",
            style: {},
            order: 1
          }
        ]
      },
      {
        order: 2,
        size: 6,
        style: {},
        elements: []
      }
    ]
  }]

  constructor(props: IBuilderProps) {
    super(props);

    this.state = {
    }
  }

  onSelectRow = (row) => {
    console.log(row)
  }

  onSave = () => {

  }

  public render() {
    return (
      <div className="builder">
        <div className="offer-page">
          <div className="container">
            { this.rows.map(row => (
              <div style={row.style} className="row">
                { row.columns.map(column => (
                  <div style={column.style} className={ "col-12" + " col-md-" + column.size }>
                    { column.elements.map((element => {
                      const Balise: any = element.type;
                      return <Balise style={ element.style || {}}>{ element.innerHtml }</Balise>
                    }))}
                  </div>
                ))}
              </div>
            ))}
          </div>
        </div>
        <div className="properties">
          <div className="p-3">
            <button onClick={this.onSave} className="btn btn-primary">Enregistrer</button>
            <h3>Structure</h3>
          </div>
          <div>
            <ColumnSettings/>
          </div>
        </div>
      </div>
    );
  }
}


if (document.getElementById('builder')) {
  ReactDOM.render(<Builder/>, document.getElementById('builder'));
}
