//make
function Make(id, name)
{
	if (typeof id !== 'undefined') this.id = id;
	if (typeof name !== 'undefined') this.name = name;
}

//model
function Model(id, name)
{
	if (typeof id !== 'undefined') this.id = id;
	if (typeof name !== 'undefined') this.name = name;
}

//car
function Car(id, description, year, price, color, image)
{
	if (typeof id !== 'undefined') this.id = id;
	if (typeof description !== 'undefined') this.description = description;
	if (typeof year !== 'undefined') this.year = year;
	if (typeof price !== 'undefined') this.price = price;
	if (typeof color !== 'undefined') this.color = color;
	if (typeof image !== 'undefined') this.image = image;
}