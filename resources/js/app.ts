
import 'moment-timezone';
import 'moment/locale/fr';
import moment from 'moment';
moment.locale("fr");

import './bootstrap'
import './components/Booker'
import './components/SlotForm'
// import './components/Builder'
import Axios from 'axios';
import toastr from 'toastr';
import 'grapesjs/dist/css/grapes.min.css';
import grapesjs from 'grapesjs';
import { initBlock } from './blocks';
// import { init } from './initBuilder';
// var host = 'http://artf.github.io/grapesjs/';
// var images = [
//   host + 'img/grapesjs-logo.png',
//   host + 'img/tmp-blocks.jpg',
//   host + 'img/tmp-tgl-images.jpg',
//   host + 'img/tmp-send-test.jpg',
//   host + 'img/tmp-devices.jpg',
// ];
function saveOfferPage(editor) {
  var data = editor.getHtml();
  var css = editor.getCss();
  Axios.post("/admin/builder", { data, css }).then((e) => {
    toastr.success("Page sauvegardée !")
  })
}


if (document.getElementById("gjs")) {
  const editor = grapesjs.init({
    height: '100%',
      canvas: {
        styles: [
          window.location.origin + '/css/app.css'
        ],
        scripts: [
          // 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js'
        ],
      },
    // panels: {defaults: []},
    // storageManager:{
    //   autoload: 0,
    // },
    // assetManager: {
    //   assets: images,
    //   upload: 0,
    //   uploadText: 'Uploading is not available in this demo',
    // },
    container: '#gjs',
    // fromElement: true,
    width: 'auto',
  });

  Axios.get("/admin/builder/html").then((response) => {
    editor.Components.setComponents(response.data.html)
    editor.setStyle(response.data.css)
  })
  console.log(editor)
  initBlock(editor)
  // editor.Panels.addPanel({
  //   id: 'panel-top',
  //   el: '.panel__top',
  // });
  // editor.Panels.addPanel({
  //   id: 'basic-actions',
  //   el: '.panel__basic-actions'
  // });
  // init(editor)

  // editor.Panels.removePanel("commands")
  // editor.Panels.removePanel("options")
  editor.Panels.removeButton("options", "export-template")
  // editor.Panels.removeButton("options", "sw-visibility")
  let pnm = editor.Panels;
  let optPanel = pnm.getPanel('options');
  pnm.addButton('options', {
    id: "saves",
    className: 'fa fa-save',
    command: () => saveOfferPage(editor),
    attributes: {title: "Enregistrer"},
  })
  optPanel.buttons.models[0].attributes.title = "Aperçu"
  optPanel.buttons.models[1].attributes.title = "Plein écran"
  ///
  let commandsPanel = pnm.getPanel('commands');
  console.log(commandsPanel)
  editor.refresh()
  
  // editor.Panels.removePanel("views")
  // editor.Panels.removePanel("devices-c")
  // editor.Panels.removePanel("views-container")

}





declare var $

$(".car-amount").change(function(e) {
  let carId = $(this).attr('data-carId');
  let value = e.target.value
  if (value == null || value == "" || value == undefined) $(this).val(parseInt($(this).attr('value')));
  else Axios.put("/admin/cars/" + carId, { available_amount: parseInt(value) }).then((e) => {
    toastr.success("La disponibilité a été mis à jour")
  })
})

$(".commercial-select").change(function (e) {
  let bookingId = $(this).attr('data-booking_id');
  let comId = e.target.value;
  Axios.put("/api/bookings/" + bookingId, { commercial_id: parseInt(comId) }).then((e) => {
    toastr.success("Le commercial a été assigné.")
  })
})
