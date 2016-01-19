//variables
var urlServer = 'http://localhost/cars2015/';
var urlImages = 'http://localhost/cars2015/images/';
var x = new XMLHttpRequest();
var newSearch = true;
var priorPage = 1;

//load index
function onLoad()
{
	//check if user is logged in
	if (sessionStorage.token != null)
	{
		//user is logged in
		var divLogin = document.getElementById('login');
		divLogin.innerHTML = sessionStorage.userName;
		//get makes
		getMakes();
	}
	else
	{
		//redirect to login page
		window.location = 'login.html';
	}
}

//get token
function getToken()
{
	console.log('Getting Token...');
	//read username and password
	var user = document.getElementById('txtUser').value;
	var password = document.getElementById('txtPassword').value;
	//petition
	x.open('GET', urlServer + 'gettoken.php', true);
	//headers
	x.setRequestHeader('user', user);
	x.setRequestHeader('password', password);
	//send petition
	x.send();
	//event handler
	x.onreadystatechange = function()
	{
		//check status
		if (x.readyState == 4 & x.status == 200)
		{
			//read response
			var data = x.responseText;
			//parse to json
			var JSONdata = JSON.parse(data);
			//check status
			if (JSONdata.status == 0)
			{
				//save info
				sessionStorage.userId = JSONdata.user;
				sessionStorage.userName = JSONdata.name;
				sessionStorage.token = JSONdata.token;
				//redirect to index
				window.location = 'index.html';
			}
			else
			{
				alert('Access Denied');
			}
		}
	}
}

//get makes
function getMakes()
{
	//request
	x.open('GET', urlServer + 'getmakes.php', true);
	//headers
	x.setRequestHeader('user', sessionStorage.userId);
	x.setRequestHeader('token', sessionStorage.token);
	//send request
	x.send();
	//event handler
	x.onreadystatechange = function()
	{
		//check status
		if (x.status == 200 & x.readyState == 4)
		{
			parseMakes(x.responseText);
		}
	}
}

//parse makes
function parseMakes(data)
{
	//parse to json
	var JSONdata = JSON.parse(data); 
	//check status
	if (JSONdata.status == 0)
	{
		//read makes JSON array
		var JSONmakes = JSONdata.makes; 
		//crate makes array
		var makes = [];
		//read JSON makes
		for (var i = 0; i < JSONmakes.length; i++)
		{
			//read array element
			var JSONmake = JSONmakes[i];
			//add make to array
			makes[i] = new Make(JSONmake.id, JSONmake.name);
		}
		showMakes(makes);
	}
}

//show makes in select
function showMakes(makes)
{
	//get select
	var selMakes = document.getElementById('selMakes');
	//add empty option
	var option = document.createElement('option');
	selMakes.appendChild(option);
	//read makes
	for (var i = 0; i < makes.length; i++)
	{
		//create option
		var option = document.createElement('option');
		//set attributes for option
		option.value = makes[i].id;
		option.text = makes[i].name;
		//add option to select
		selMakes.appendChild(option);
	}
}

//get models
function getModels(makeId)
{
	if (makeId != '')
	{
		//request
		x.open('GET', urlServer + 'getmodels.php?makeid=' + makeId, true);
		//headers
		x.setRequestHeader('user', sessionStorage.userId);
		x.setRequestHeader('token', sessionStorage.token);
		//send request
		x.send();
		//event handler
		x.onreadystatechange = function()
		{
			//check status
			if (x.status == 200 & x.readyState == 4)
			{
				parseModels(x.responseText);
			}
		}
	}
}

//parse makes
function parseModels(data)
{
	//parse to json
	var JSONdata = JSON.parse(data); 
	//check status
	if (JSONdata.status == 0)
	{
		//read models JSON array
		var JSONmodels = JSONdata.models; 
		//crate models array
		var models = [];
		//read JSON models
		for (var i = 0; i < JSONmodels.length; i++)
		{
			//read array element
			var JSONmodel = JSONmodels[i];
			//add model to array
			models[i] = new Model(JSONmodel.id, JSONmodel.name);
		}
		showModels(models);
	}
}

//show models
function showModels(models)
{
	//get select
	var selModels = document.getElementById('selModels');
	//erase previous options
	selModels.innerHTML = '';
	//add empty option
	var option = document.createElement('option');
	selModels.appendChild(option);
	//read models
	for (var i = 0; i < models.length; i++)
	{
		//create option
		var option = document.createElement('option');
		//set attributes for option
		option.value = models[i].id;
		option.text = models[i].name;
		//add option to select
		selModels.appendChild(option);
	}
}

//get cars
function getCars(pageNumber)
{
	//leer datos
	var modelId = document.getElementById('selModels').value;
	var minPrice = document.getElementById('txtPriceMin').value;
	var maxPrice = document.getElementById('txtPriceMax').value;
	var minYear = document.getElementById('txtYearMin').value;
	var maxYear = document.getElementById('txtYearMax').value;
	var orderBy = document.getElementById('selOrderBy').selectedIndex;
	var rowsPerPage = document.getElementById('selRowsPerPage').value;
	//url
	var url = urlServer + 'getcars.php?id=' + modelId;
	if (minPrice != '') url += '&minprice=' + minPrice;
	if (maxPrice != '') url += '&maxprice=' + maxPrice;
	if (minYear != '') url += '&minyear=' + minYear;
	if (maxYear != '') url += '&maxyear=' + maxYear;
	url += '&orderby=' + orderBy;
	url += '&rowsperpage=' + rowsPerPage;
	url += '&pagenumber=' + pageNumber;
	//request
	x.open('GET', url , true);
	//headers
	x.setRequestHeader('user', sessionStorage.userId);
	x.setRequestHeader('token', sessionStorage.token);
	//send request
	x.send();
	//event handler
	x.onreadystatechange = function()
	{
		//check status
		if (x.status == 200 & x.readyState == 4)
		{
			var JSONdata = JSON.parse(x.responseText);
			if (newSearch) showPaging(JSONdata.paging);
			//parseCars
			parseCars(JSONdata);
		}
	}
}

//show paging
function showPaging(JSONpaging)
{
	newSearch = false;
	priorPage = 1;
	//paging division
	var divPaging = document.getElementById('paging');
	divPaging.innerHTML = ''; //empty division
	//create pages
	for (var p = 1; p <= JSONpaging.pageCount; p++)
	{
		//create button
		var button = document.createElement('button');
		//attibutes
		button.setAttribute('id', 'buttonPage' + p);
		if (p == 1)
			button.className = 'buttonActivePage';
		else
			button.className = 'buttonPage';
		button.innerHTML = p;
		//events
		button.setAttribute("onMouseOver", "if (this.className != 'buttonActivePage') this.className='buttonPageOver';");
		button.setAttribute("onMouseOut", "if (this.className != 'buttonActivePage') this.className='buttonPage';");
		button.setAttribute('onClick', 'getCars(' + p + ');');
		//add to paging
		divPaging.appendChild(button);
	}
}

//parse cars
function parseCars(JSONdata)
{
	//change page style
	document.getElementById('buttonPage' + priorPage).className = 'buttonPage';
	document.getElementById('buttonPage' + JSONdata.paging.pageNumber).className = 'buttonActivePage';
	priorPage = JSONdata.paging.pageNumber;
	//parse data
	if (JSONdata.status == 0)
	{
		//cars array
		var cars = [];
		//get JSON cars
		var JSONcars = JSONdata.cars;
		//read cars array
		for(var i = 0; i < JSONcars.length; i++)
		{
			//read car
			var JSONcar = JSONcars[i];
			//add car to array
			cars[i] = new Car(JSONcar.id, JSONcar.description, JSONcar.year, JSONcar.price, JSONcar.color, JSONcar.image);
		}
		//show cars
		showCarsInDivisions(cars);
	}
}

//show cars in table
function showCarsInTable(cars)
{
	//table
	var table = document.getElementById('tablecars');
	//clear rows
	clearTableRows();
	//row class
	var rowClass = 'tablecarsrow';
	//read cars
	for (var i = 0; i < cars.length; i++)
	{
		//car
		var car = cars[i];
		//create row
		var row = document.createElement('tr');
		//row class
		row.className = rowClass;
		//create cells
		var cellImage = document.createElement('td');
		var cellId = document.createElement('td');
		var cellYear = document.createElement('td');
		var cellPrice = document.createElement('td');
		var cellColor = document.createElement('td');
		//create image
		var imgCar = document.createElement('img');
		//image src
		imgCar.src = urlImages + car.image;
		//cell data
		cellId.innerHTML = car.id;
		cellYear.innerHTML = car.year;
		cellPrice.innerHTML = toCurrency(car.price);
		cellColor.innerHTML = car.color;
		//add image to cell
		cellImage.appendChild(imgCar);
		//add cells to row
		row.appendChild(cellImage);
		row.appendChild(cellId);
		row.appendChild(cellYear);
		row.appendChild(cellPrice);
		row.appendChild(cellColor);
		//add row to table
		table.appendChild(row);
		//alternate row class
		if (rowClass == 'tablecarsrow')
			rowClass = 'tablecarsrowalternate';
		else
			rowClass = 'tablecarsrow';
	}
}

//format currency
function toCurrency(value)
{
	return value.toLocaleString("en-US", 
					{style: "currency", 
					currency:"USD",
					minimumFractionDigits:2});
}

//clear table rows
function clearTableRows()
{
	var table = document.getElementById('tablecars');
	for (var i = table.rows.length - 1; i > 0; i--)
	{
		table.deleteRow(i);
	}
}

//show cars in table
function showCarsInDivisions(cars)
{
	//div cars
	var divCars = document.getElementById('cars');
	//read cars
	for (var i = 0; i < cars.length; i++)
	{
		//car
		var car = cars[i];
		//create division
		var divCar = document.createElement('div');
		var divImage = document.createElement('div');
		var divDescription = document.createElement('div');
		var divColor = document.createElement('div');
		var divPrice = document.createElement('div');
		//create image
		var imgCar = document.createElement('img');
		//image src
		imgCar.src = urlImages + car.image;
		//div content
		divImage.appendChild(imgCar);
		divDescription.innerHTML = car.description;
		divColor.innerHTML = car.color;
		divPrice.innerHTML = toCurrency(car.price);
		//div styles
		divCar.className = 'divcar';
		divImage.className = 'divcarimage';
		divDescription.className = 'divcardescription';
		divColor.className = 'divcarcolor';
		divPrice.className = 'divcarprice';
		//add to divCar
		divCar.appendChild(divImage);
		divCar.appendChild(divDescription);
		divCar.appendChild(divColor);
		divCar.appendChild(divPrice);
		//add to div Cars
		divCars.appendChild(divCar);
	}
}


















