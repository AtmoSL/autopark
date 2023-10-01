const addCarBtn = document.getElementById("add-car");
const allCars = document.getElementById("all-cars");
let carCounter = document.querySelectorAll('.car__row').length;


addCarBtn.addEventListener("click", (event) => {
    const carForm = createCarForm(carCounter);
    carCounter++;
    allCars.append(carForm);
});


// Формирование формы для машин
function createCarForm(carCounter){
    const carForm = document.createElement('div');
    carForm.className = "car__row d-flex justify-content-between";
    carForm.innerHTML ="<label for=\"number\" class=\"form-label text-center\">Номер машины\n" +
        "                        <input type=\"text\"\n" +
        "                               name=\"cars[car"+carCounter+"][number]\"\n" +
        "                               id=\"number\"\n" +
        "                               class=\"form-control\"></label>\n" +
        "\n" +
        "                    <label for=\"driver_name\" class=\"form-label text-center\">Имя водителя\n" +
        "                        <input type=\"text\"\n" +
        "                               name=\"cars[car"+carCounter+"][driver_name]\"\n" +
        "                               id=\"driver_name\"\n" +
        "                               class=\"form-control\"> </label>";
    return carForm;
}