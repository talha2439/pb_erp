
<div class="modal fade" id="notificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Notifications</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card">
                <div class="card-body">
                    <div class="main-div p-2 mb-2 mt-2 border">
                        <div class="d-flex">
                            <div  style="border-right: 1px solid rgb(190, 190, 190)!important ; padding-right:10px;" class=""><button class="btn mt-2 rounded-5 blink blink-purple"><i class="fe fe-mail"></i></button></div>
                            <div class="p-2 row w-100"><div class="col-md-10 "><h5 class="mt-0  " style="margin-left:7px">Testing Mail </h5> <small class="p-2"> june 29, 2024 10:30pm</small></div> <div class="col-md-2"><button class="btn btn-primary float-end"  data-bs-toggle="collapse" data-bs-target="#messageToggle" aria-expanded="false" aria-controls="messageToggle"><i class="fe fe-chevrons-down"></i></button></div></div>
                        </div>
                        {{-- Appended data message --}}
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item border-0">
                              <h2 class="accordion-header" id="messageToggle">
                              </h2>
                              <div id="messageToggle" class="accordion-collapse collapse" aria-labelledby="messageToggle" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <hr>
                                    <div class="card">
                                        <div class="card-body ">
                                            <div class="card-text p-0">Information:br</div>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                    </div>


                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
