const addCarBtn = document.getElementById("add-car");
const allCars = document.getElementById("all-cars");
const deleteAutoparkBtn = document.getElementById("deleteAutopark");

//Предупреждение при удалении автопарка
if (deleteAutoparkBtn) {
    deleteAutoparkBtn.addEventListener("click", (event) => {
        const isDelete = confirm("Автопарк будет удалён без возможности восстановления. Машины останутся в базе.");

        if (isDelete) {
            window.location.href = '/autopark/delete?id=' + deleteAutoparkBtn.dataset.autoparkId;
        }

    });
}

//Добавление поля для машины на странице создания автопарка
if (addCarBtn) {
    addCarBtn.addEventListener("click", (event) => {
        const carId = Math.random();
        const carForm = createCarForm(carId);
        allCars.append(carForm);

        const deleteBtn = document.getElementById("delete-" + carId );

        deleteBtn.addEventListener("click", function (event) {
            console.log("asd");
            const carRow = document.getElementById("car-row-" + carId);
            carRow.remove();
        });

    });
}


// Формирование формы для машин
function createCarForm(carCounter) {
    const carForm = document.createElement('div');
    carForm.className = "car__row d-flex justify-content-between";
    carForm.id = "car-row-" + carCounter;
    carForm.innerHTML = "<label for=\"number\" class=\"form-label text-center\">Номер машины\n" +
        "                        <input type=\"text\"\n" +
        "                               name=\"cars[car" + carCounter + "][number]\"\n" +
        "                               id=\"number\"\n" +
        "                               class=\"form-control\"></label>\n" +
        "\n" +
        "                    <label for=\"driver_name\" class=\"form-label text-center\">Имя водителя\n" +
        "                        <input type=\"text\"\n" +
        "                               name=\"cars[car" + carCounter + "][driver_name]\"\n" +
        "                               id=\"driver_name\"\n" +
        "                               class=\"form-control\"> </label>" +
        "                   <div class='delete_car' id=\"delete-" + carCounter + "\">Х</div>"
    ;
    return carForm;
}