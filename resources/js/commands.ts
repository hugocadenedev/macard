function tglImagesCommand(opt?: any) {
  const toggleImages = (components, on?) => {
      const srcPlh = '##';

      components.each((component) => {
          if (component.get('type') === 'image') {
              const source = component.get('src');

              if (on) {
                  if (source === srcPlh) {
                      component.set('src', component.get('src_bkp'));
                  }
              } else if (source !== srcPlh) {
                  component.set('src_bkp', component.get('src'));
                  component.set('src', srcPlh);
              }
          }

          toggleImages(component.get('components'), on);
      });
  };

  return {
      run(editor) {
          const components = editor.getComponents();
          toggleImages(components);
      },
      stop(editor) {
          const components = editor.getComponents();
          toggleImages(components, 1);
      },
  };
};

export default function() {
  return (opt: any = {}) => {
    let editor = opt.editor;
    let cmdm = editor.Commands;
    // let importCommand = require('./openImportCommand');
    // let exportCommand = require('./openExportCommand');
    // cmdm.add(opt.cmdOpenImport, importCommand(opt));
    cmdm.add(opt.cmdTglImages, tglImagesCommand(opt));

    // Overwrite export template after the editor is loaded
    // (default commands are loaded after plugins)
    editor.on('load', () => {
      // cmdm.add('export-template', exportCommand(opt));
    });

    cmdm.add('undo', {
      run(editor, sender) {
        sender.set('active', 0);
        editor.UndoManager.undo(1);
      }
    });
    cmdm.add('redo', {
      run(editor, sender) {
        sender.set('active', 0);
        editor.UndoManager.redo(1);
      }
    });
    cmdm.add('set-device-desktop', {
      run(editor) {
        editor.setDevice('Desktop');
      }
    });
    cmdm.add('set-device-tablet', {
      run(editor) {
        editor.setDevice('Tablet');
      }
    });
    cmdm.add('set-device-mobile', {
      run(editor) {
        editor.setDevice('Mobile portrait');
      }
    });
  };
}
