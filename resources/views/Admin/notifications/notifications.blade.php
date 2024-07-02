@extends('Admin.layout')
@section('title')
All Notifications
@endsection
@section('content')

    <div class="page-header">
    <div class="content-page-header">
    <h5>All Notifications</h5>
    </div>
    </div>
    <div class="card p-3">
        <div class="card-header mb-2">
            <div class="row">
               <div class="col-md-12 d-flex justify-content-between">
                <h3>All Notifications</h3>
                <a href="#" class="btn btn-primary"  data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"><i class="fe fe-filter"></i></a>
               </div>
                <div class="col-md-12">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item border-0">
                          <h2 class="accordion-header" id="headingThree">
                          </h2>
                          <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                             @include('Admin.notifications.partial.filter')
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
        <div class="table-responsive pt-0">
            <table class="datatables-basic table table-bordered">
              <thead>
                <tr>

                  <th>#</th>
                  <th>Subject</th>
                  <th>Date and Time</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
    </div>

</div>
@push('js')
 
  <script src="{{ asset('assets/custom/notification/notification_index.js') }}"></script>
   <script>


        let deleteUrl  = "{{ route('notifications.delete') }}";
        let allNotificationsURL = "{{ route('notifications.alldata') }}";

   </script>

    @endpush
@endsection
