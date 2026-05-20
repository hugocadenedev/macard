import * as React from 'react';

export interface IColumnSettingsProps {
}

export interface IColumnSettingsState {
}

export default class ColumnSettings extends React.Component<IColumnSettingsProps, IColumnSettingsState> {
  constructor(props: IColumnSettingsProps) {
    super(props);

    this.state = {
    }
  }

  public render() {
    return (
      <div>
        <div>reglages</div>
      </div>
    );
  }
}
