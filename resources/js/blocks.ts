export function initBlock (editor, opt = {}) {
  const c: any = {
    blocks: ['column1', 'column2', 'column3', 'column3-7', 'text', 'link', 'image'],
    flexGrid: 0,
    stylePrefix: 'gjs-',
    addBasicStyle: true,
    category: 'Basic',
    labelColumn1: '1 Colonne',
    labelColumn2: '2 Colonne',
    labelColumn3: '3 Colonne',
    labelColumn37: '2 Colonne 5/12',
    labelText: 'Texte',
    labelLink: 'Lien',
    labelImage: 'Image'
  };
  let bm = editor.BlockManager;
  let blocks = c.blocks;
  let stylePrefix = c.stylePrefix;
  const flexGrid = c.flexGrid;
  const basicStyle = c.addBasicStyle;
  const clsRow = `${stylePrefix}row`;
  const clsCell = `${stylePrefix}cell`;

  const step = 0.2;
  const minDim = 1;
  const currentUnit = 1;
  const resizerBtm = { tl: 0, tc: 0, tr: 0, cl: 0, cr:0, bl:0, br: 0, minDim };
  const resizerRight: any = { ...resizerBtm, cr: 1, bc: 0, currentUnit, minDim, step };

  // Flex elements do not react on width style change therefore I use
  // 'flex-basis' as keyWidth for the resizer on columns
  if (flexGrid) {
    resizerRight.keyWidth = 'flex-basis';
  }

  const rowAttr = {
    class: clsRow,
    'data-gjs-droppable': `.${clsCell}`,
    'data-gjs-resizable': resizerBtm,
    'data-gjs-name': 'Row',
  };

  const colAttr = {
    class: clsCell,
    'data-gjs-draggable': `.${clsRow}`,
    'data-gjs-resizable': resizerRight,
    'data-gjs-name': 'Cell',
  };

  if (flexGrid) {
    colAttr['data-gjs-unstylable'] = ['width'];
    colAttr['data-gjs-stylable-require'] = ['flex-basis'];
  }

  // Make row and column classes private
  const privateCls = [`.${clsRow}`, `.${clsCell}`];
  editor.on('selector:add', selector =>
    privateCls.indexOf(selector.getFullName()) >= 0 && selector.set('private', 1))

  const attrsToString = attrs => {
    const result = [];

    for (let key in attrs) {
      let value = attrs[key];
      const toParse = value instanceof Array || value instanceof Object;
      value = toParse ? JSON.stringify(value) : value;
      result.push(`${key}=${toParse ? `'${value}'` : `"${value}"`}`);
    }

    return result.length ? ` ${result.join(' ')}` : '';
  }

  const toAdd = name => blocks.indexOf(name) >= 0;
  const attrsRow = attrsToString(rowAttr);
  const attrsCell = attrsToString(colAttr);

  toAdd('column1') && bm.add('column1', {
    label: c.labelColumn1,
    category: c.category,
    attributes: {class:'gjs-fonts gjs-f-b1'},
    content: `
    <div class='container-fluid'>
      <div class='row'>
        <div class='col-12' style='min-height: 50px'></div>
        <div class='col-12' style='min-height: 50px'></div>
      </div>
    </div>
      ${ basicStyle ?
        `<style>
        </style>`
        : ''}`
  });

  toAdd('column2') && bm.add('column2', {
    label: c.labelColumn2,
    attributes: {class:'gjs-fonts gjs-f-b2'},
    category: c.category,
    content: `
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-md-6' style='min-height: 50px'></div>
          <div class='col-md-6' style='min-height: 50px'></div>
        </div>
      </div>
      ${ basicStyle ?
        `<style>
        </style>`
        : ''}`
  });

  toAdd('column3') && bm.add('column3', {
    label: c.labelColumn3,
    category: c.category,
    attributes: {class:'gjs-fonts gjs-f-b3'},
    content: `
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-md-4' style='min-height: 50px'></div>
          <div class='col-md-4' style='min-height: 50px'></div>
          <div class='col-md-4' style='min-height: 50px'></div>
        </div>
      </div>
      ${ basicStyle ?
        `<style>
        </style>`
        : ''}`
  });

  toAdd('column3-7') && bm.add('column3-7', {
    label: c.labelColumn37,
    category: c.category,
    attributes: {class:'gjs-fonts gjs-f-b37'},
    content: `
    <div class='container-fluid'>
      <div class='row'>
        <div class='col-md-5' style='min-height: 50px'></div>
        <div class='col-md-7' style='min-height: 50px'></div>
      </div>
    </div>
      ${ basicStyle ?
        `<style>
        </style>`
        : ''}`
  });

  toAdd('text') && bm.add('text', {
    label: c.labelText,
    category: c.category,
    attributes: {class:'gjs-fonts gjs-f-text'},
    content: {
      type:'text',
      content:'Insert your text here',
      style: {padding: '10px' },
      activeOnRender: 1
    },
  });

  toAdd('link') && bm.add('link', {
    label: c.labelLink,
    category: c.category,
    attributes: {class:'fa fa-link'},
    content: {
      type:'link',
      content:'Link',
      style: {color: '#d983a6'}
    },
  });

  toAdd('image') && bm.add('image', {
    label: c.labelImage,
    category: c.category,
    attributes: {class:'gjs-fonts gjs-f-image'},
    content: {
      style: {color: 'black', width: "100%"},
      type:'image',
      activeOnRender: 1
    },
  });

}
