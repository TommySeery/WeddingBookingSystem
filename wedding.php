<!DOCTYPE html>
<html>
<head>
<title>Wedding Booking System</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<style>
body {
  font-family: Arial;
}

#search{
    display: none;
}

.r1{
    background-color: #89CFF0;
}

.r2{
    background-color: #ADD8E6;
}

th{
    background-color: #0D6EFD;
    color: white;
}

th, td {
    padding: 15px;
    text-align: left;
}

table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}

table {
    display: block;
    overflow-x: auto;
    white-space: nowrap;
    padding: 15px;
}

table tbody {
    display: table;
    width: 100%;
}

#home {  
  display: flex;
  flex-wrap: wrap;
}

#aboutUs {
  flex: 30%;
  background-color: #ADD8E6;
  padding: 15px;
}

#slideShow {
  flex: 70%;
  background-color: #89CFF0;
  padding: 15px;
}

.carousel-item > div > h5{
    font-weight: bold;
}

.footer {
  padding: 15px;
  text-align: left;
}

.footer > p > br{
    line-height:10px;
}

#weddingForm{
    padding:30px;
}

#weddingForm > label{
    padding-bottom: 15px;
}

#weddingForm > input[type=number]{
    display: inline-block;
    width: 120px;
}

input[type=submit] {
    width: 100px;
    background-color: #0D6EFD;
    color: white;
    border-radius:8px;
}

#serverResponse > p{
    padding-left: 30px;
}

#whyUs {
  display: flex;
  background-color: #89CFF0;
}

#home > h4{
    padding-top: 15px;
    padding-left:15px;
}

.column {
  flex: 33.33%;
  padding: 5px;
}

.column > img{
    width: 100%;
}

/* When screen goes below 900 pixels, puts #aboutUs and #slideShow on top of each other,
Along with the 3 column pictures on top of each other */
@media screen and (max-width: 900px) {
  #aboutUs, #slideShow {   
    flex:100%
  }

  #whyUs, .column {   
    flex-direction: column;
  }
}



</style>
</head>
<body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function displaySearch(){
            $("#home").hide();
            $("#search").show();
        }

        function displayHome(){
            $("#search").hide();
            $("#home").show();
        }

        $(document).ready(function(){
            $("#weddingForm").submit(function(event){
                event.preventDefault();
                let date = $("#date").val();
                let size = $("#partySize").val();
                let grade = $("#cateringGrade").val();
                if(size < 0 || (grade<1 || grade>5) || parseInt(size)==NaN || parseInt(grade)==NaN || Date.parse(date)==NaN){
                    $("#serverResponse").html("<p>Invalid Input</p>");
                }else{
                $.get("weddingprocess.php", {'date' : date, 'partySize': size, 'cateringGrade' : grade}, function(responseData){  
                    let len = responseData.length;
                    let table = "<table><tr>"+
                    "<th>Name</th>"+
                    "<th>Capacity</th>"+
                    "<th>Licensed</th>"+
                    "<th>Catering cost (per person)</th>"+
                    "<th>Weekday Price</th>"+
                    "<th>Weekend Price</th>"+
                    "<th>Total Price</th>"+
                    "<th>No. of Bookings</th>"+
                    "<th>Day of Week</th>"+
                    "</tr>";
                    for(let i=0; i<len; i++){
                        let name = responseData[i].name;
                        let capacity = responseData[i].capacity
                        let licensed = responseData[i].licensed;
                        let cost = responseData[i].cost;
                        let wdprice =responseData[i].weekday_price
                        let weprice =responseData[i].weekend_price;
                        let totalPrice = responseData[i].total;
                        let bookings = responseData[i]['COUNT(name)'];
                        let day = responseData[i][`DAYNAME('${date}')`];
                        table+=`<tr class="r${(i % 2)+1}">`+
                        "<td>"+ name + "</td>"+
                        "<td>" + capacity + "</td>"+
                        "<td>" + licensed +"</td>"+
                        "<td> £"+ cost + "</td>"+
                        "<td> £"+ wdprice + "</td>"+
                        "<td> £"+ weprice + "</td>"+
                        "<td> £"+ totalPrice + "</td>"+
                        "<td>"+ bookings + "</td>"+
                        "<td>"+ day + "</td>"+
                        "</tr>";
                    }
                    table+="</table>";
                    $("#serverResponse").html(table);
                }, "json");
            }
            });
        });
</script>


<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <header class="mb-auto">
        <div>
            <h1 class="float-md-start mb-0">Wedding Booking System</h1>
        </div>
    </header>
</div>


<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href='#' onclick="displayHome()">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href='#' onclick="displaySearch()">Search</a>
            </li>
        </ul>
    </nav>

<div id ="home">
  <div id="aboutUs">
    <h3>About Us</h3>
    <p>Here at super weddings, we make quality and variety our two crucial priorities. We offer a vast range of wedding venues: From islands and beaches to pictureque villages!</p>
    <br>
    <p>And now, booking is as simple as ever with our brand new booking system. Simply click on 'search', and type in your weddings date, number of party members and the venue grade that you desire, 
        and our system will give you a vast variety of wedding venues to choose from</p>
    <br>
    <p>Please have a look at some of our wonderful venues using our slideshow!</p>
  </div>
  <div id="slideShow">
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
            <img src="weddingpic1.jpg" class="d-block w-100" alt="Southwestern Estate">
                <div class="carousel-caption d-none d-md-block">
                <h5>Southwestern Estate</h5>
                </div>
            </div>
            <div class="carousel-item">
            <img src="weddingpic2.jpg" class="d-block w-100" alt="Haslegrave Hotel">
                <div class="carousel-caption d-none d-md-block">
                <h5>Haslegrave Hotel</h5>
                </div>
            </div>
            <div class="carousel-item">
            <img src="weddingpic3.jpg" class="d-block w-100" alt="Central Plaza">
                <div class="carousel-caption d-none d-md-block">
                <h5>Central Plaza</h5>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    </div>
        <h4>Why choose us?</h4>
        <div id="whyUs">
            <div class="column">
                <img src="happycouple.jpg" alt="A Happy Couple">
                <figcaption>
                    <h5>High Ratings</h5>
                    <p>Rated '#1 Best Wedding Service' based on customer satisfaction</p>
                </figcaption>
            </div>
            <div class="column">
                <img src="weddingfood.jpg" alt="Wedding Food">
                <figcaption>
                    <h5>Exquisite Food</h5>
                    <p>We offer the most high quality food along with your lovely wedding</p>
                </figcaption>
            </div>
            <div class="column">
                <img src="weddingpic4.jpg" alt="Sea View Tavern: One of our many venues">
                <figcaption>
                    <h5>Luxury</h5>
                    <p>Wondering Wedding Venues with serene, panoramic views!</p>
                </figcaption>
            </div>
        </div>
        <div class="footer">
        <h4>Contact Us</h4>
        <p>Email:bookings@superweddings.co.uk<br>
        Tel: 07945 852 966</p>
    </div>
</div>

<div id="search">
    <form id="weddingForm">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date"><br>
        <label for="partySize">Party Size:</label>
        <input type="number" id="partySize" name="partySize"><br>
        <label for="cateringGrade">Catering Grade:</label>
        <input type=number id="cateringGrade" name="cateringGrade"><br>
        <input type=submit>
    </form>
    <div id="serverResponse"></div>
</div>

</body>
</html>


