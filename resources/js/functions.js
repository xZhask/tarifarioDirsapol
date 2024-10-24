/* Validar */
if (document.querySelector("#frmExcelImport")) {
  const form = document.querySelector("#frmExcelImport");
  const contTable = document.querySelector("#cont-result");
  const loadValidate = document.querySelector("#load-validate");
  form.addEventListener("submit", async (e) => {
    loadValidate.style.opacity = 1;
    loadValidate.style.visibility = "visible";
    e.preventDefault();
    let frm = document.querySelector("#frmExcelImport");
    let datos = new FormData(frm);
    datos.append("accion", "VALIDAR");
    let respuesta = await postData(datos);
    loadValidate.style.opacity = 0;
    loadValidate.style.visibility = "hidden";
    if (respuesta.result > -1) {
      contTable.innerHTML = respuesta.data;
      if (respuesta.result == 1)
        $("#btn-export").prop(
          "href",
          `resources/libraries/Excel/validation.php`
        );
    } else {
      alert(respuesta.data);
    }
  });
}
if (document.querySelector("#btn-reset")) {
  const btnReset = document.querySelector("#btn-reset");
  const btnExport = document.querySelector("#btn-export");
  const inputFile = document.querySelector("#mi-archivo");
  const contTable = document.querySelector("#cont-result");
  const textoFile = document.querySelector("#lbl-miarchivo");
  const btnValidar = document.querySelector("#submit");
  btnReset.addEventListener("click", async () => {
    inputFile.value = "";
    textoFile.textContent = "Click para seleccionar Archivo Excel";
    contTable.innerHTML = "";
    btnValidar.classList.remove("active");
    btnExport.removeAttribute("href");
  });
}
if (document.querySelector("#ipress-validador")) {
  document.querySelector("#ipress-validador").value =
    localStorage.getItem("ipress");
}
if (document.querySelector("#mi-archivo")) {
  const myFile = document.querySelector("#mi-archivo");
  const textoFile = document.querySelector("#lbl-miarchivo");
  const btnValidar = document.querySelector("#submit");
  myFile.addEventListener("change", () => {
    filename = myFile.value.split("\\").pop();
    textoFile.textContent = filename;
    btnValidar.classList.add("active");
  });
}
if (document.querySelector("#submit")) {
  const myFile = document.querySelector("#mi-archivo");
  const btnValidar = document.querySelector("#submit");
  btnValidar.addEventListener("click", () => {
    if (myFile.value == "") alert("Seleccione archivo");
  });
}
const inputIpress = document.querySelector("#ipress");
const inputProcedimiento = document.querySelector("#procedimiento");
const tbTarifario = document.querySelector("#tbCpms");
const contLoader = document.querySelector(".preloader");
const lnkValidar = document.querySelector("#lnk-validar");

let nivelIpress;
let tarifario = [];

window.addEventListener("load", async () => {
  contLoader.style.opacity = 0;
  contLoader.style.visibility = "hidden";

  const datos = new FormData();
  datos.append("accion", "LISTAR_UNIDADES");
  const cargarUnidades = await postData(datos);
  const unidadesList = cargarUnidades.map((unidad) => unidad.nombreIpress);
  CargarAutocompletado(unidadesList, cargarUnidades);
  console.log(unidadesList);
});

async function postData(data) {
  const response = await fetch("App/controller/controller.php", {
    method: "POST",
    body: data,
  }).then((res) => res.json());
  return await response;
}
function CargarAutocompletado(list, unidades) {
  $("#ipress").autocomplete({
    source: list,
    select: (e, item) => {
      let unidad = item.item.value;
      let position = list.indexOf(unidad);
      nivelIpress = unidades[position].nivel;
      console.log(unidad);
      cargarTarifario(nivelIpress);
      localStorage.setItem("ipress", unidad);
    },
  });
}
async function cargarTarifario(nivel) {
  let datos = new FormData();
  datos.append("accion", "CARGAR_TARIFARIO");
  datos.append("nivelIpress", nivel);
  tarifario = await postData(datos);
  renderTabla(tarifario);
}

const crearFilasTabla = (tarifario) =>
  tarifario
    .map(
      (procedimiento, indice) =>
        `<tr><td>${indice + 1}</td><td>${procedimiento.cpms}</td><td>${
          procedimiento.descripcion_cpms
        }</td><td>S/.${procedimiento.precio}</td></tr>`
    )
    .join("");

function renderTabla(tarifario) {
  const filasString = crearFilasTabla(tarifario);
  tbTarifario.innerHTML = filasString;
  $(".bg-dark").css("display", "none");
  $("#btnExcel").prop(
    "href",
    `resources/libraries/Excel/tarifario.php?nvl=${nivelIpress}`
  );
}
inputProcedimiento.addEventListener("keyup", (e) => {
  const nuevaTabla = tarifario.filter((procedimiento) =>
    `${procedimiento.descripcion_cpms.toLowerCase()} ${procedimiento.cpms.toLowerCase()}`.includes(
      inputProcedimiento.value.toLowerCase()
    )
  );
  renderTabla(nuevaTabla);
});
posicionarBuscador();

$(window).scroll(function () {
  posicionarBuscador();
});

function posicionarBuscador() {
  var alturaHeader = $("header").outerHeight(true);
  if ($(window).scrollTop() >= alturaHeader) {
    $(".cont-search").addClass("fixed");
    $(".cont-table").css("margin-top", "135px");
  } else {
    $(".cont-search").removeClass("fixed");
    $(".cont-table").css("margin-top", "0");
  }
}
lnkValidar.addEventListener("click", () => {
  window.open("validarcpms.php", "_blank");
  window.focus();
});
