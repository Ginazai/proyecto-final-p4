<!-- main carousel -->
<div class="container-fluid border border-0 d-flex flex-column p-0">
<div id="carouselExampleIndicators" class="border border-0 carousel slide" data-bs-ride="true">
  <div class="carousel-indicators visually-hidden">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner" style="max-height: 600px;">
    <div class="carousel-item active">
      <img class="w-100" src="html/assets/images/illustration/slide_1.png" style="height: 600px; width: 100%;">          
    </div>
    <div class="carousel-item" style="height: 600px; width: 100%;">
      <img class="w-100" src="html/assets/images/illustration/slide_2.png" style="height:600px;">
    </div>
    <div class="carousel-item">
      <img class="w-100" src="html/assets/images/illustration/slide_3.png" style="height:600px;">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="visually-hidden">Next</span>
  </button>
</div>
<!-- buttons -->
<div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-3 mx-0">
      <div class="col">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4" style="background-image: url('unsplash-photo-1.jpg');">
          <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
            <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Mantenimiento</h3>
            <ul class="d-flex list-unstyled mt-auto">
              <li class="me-auto">
                <img src="html/assets/images/icons/maintenance-white.png" alt="Bootstrap" width="40" height="40">
              </li>
              <li class="d-flex align-items-center">
                <svg class="bi me-2" width="1em" height="1em"><use xlink:href="#calendar3"></use></svg>
                <small>ir</small>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card card-cover h-100 overflow-hidden rounded-4" style="background-image: url('unsplash-photo-2.jpg');">
          <div class="d-flex flex-column h-100 p-5 pb-3 text-dark text-shadow-1">
            <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Reparacion</h3>
            <ul class="d-flex list-unstyled mt-auto">
              <li class="me-auto">
                <img src="html/assets/images/icons/repair.png" alt="Bootstrap" width="40" height="40">
              </li>
              <li class="d-flex align-items-center">
                <svg class="bi me-2" width="1em" height="1em"><use xlink:href="#calendar3"></use></svg>
                <small>ir</small>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4" style="background-image: url('unsplash-photo-3.jpg');">
          <div class="d-flex flex-column h-100 p-5 pb-3 text-shadow-1">
            <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Otros</h3>
            <ul class="d-flex list-unstyled mt-auto">
              <li class="me-auto">
                <img src="html/assets/images/icons/other-white.png" alt="Bootstrap" width="40" height="40">
              </li>
              <li class="d-flex align-items-center">
                <svg class="bi me-2" width="1em" height="1em"><use xlink:href="#calendar3"></use></svg>
                <small>ir</small>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
<!-- buttons -->
</div>
<!-- main carousel -->