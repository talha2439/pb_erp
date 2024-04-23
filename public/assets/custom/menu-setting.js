$(document).ready(function(){
    getIcons();
    // You can find the function below.
    let hasMenuSwitch    = $(".switch-input");
    let submenuContainer = $(".subContainer");
    let menuRoute        = $('.menu_route');
    let menuContainer    = $(".menu_container");
    let menuForm         = $("#menuForm");
    // Input Elements variables

    let menutitle       = $(".menuTitle");
    let name             = $('input[name="name"]');
    let icon             = $('select[name="icon"]');

    $(hasMenuSwitch).on('change', function(e){
        if($(this).is(':checked')){
            let submenudata = `
            <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="name">Sub-Menu Name</label>
                    <input type="text" name="sub_menu_name[]" placeholder="Enter Sub-Menu Name" class="form-control mt-3 mb-3">
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="name">Sub-Menu Route</label>
                    <input type="text" name="route[]" placeholder="Enter Sub-Menu Route" class="form-control mt-3 mb-3">

                </div>
            </div>
            <div class="col-md-2">
               <div class="form-group">
                <label for="" class="mb-3"></label>
                <button class="btn mt-4 mb-2 btn-success btn-sm" id="addSubMenu" style="margin-top:44px!important"><i class="fe fe-plus"></i></button>
               </div>
            </div>
            </div>`;
            submenuContainer.append(submenudata);
            submenuContainer.fadeIn();
            menuRoute.fadeOut();
            $(menuRoute).find('.menuInputRoute').remove();
            menuContainer.addClass('col-md-4');
        }
        else{
            let routeData = `<div class="form-group menuInputRoute">
                <label for="name">Menu Route</label>
                <input type="text" name="route[]" placeholder="Enter Menu Route" class="form-control mt-3 mb-3">
            </div>`;
            submenuContainer.html("");
            menuRoute.fadeIn();
            menuRoute.append(routeData);
            menuContainer.removeClass('col-md-4');


        }
    });
//  Sript to append multiple Submenus
    $(document).on('click' , '#addSubMenu', function(e){
    e.preventDefault();
    let subMenuData = "";
     subMenuData  = `
        <div class="row">
        <div class="col-md-5">
        <div class="form-group">
            <label for="name">Sub-Menu Name</label>
            <input type="text" name="sub_menu_name[]" placeholder="Enter Sub-Menu Name" class="form-control mt-3 mb-3">
        </div>
        </div>
        <div class="col-md-5">
        <div class="form-group">
            <label for="name">Sub-Menu Route</label>
            <input type="text" name="route[]" placeholder="Enter Sub-Menu Route" class="form-control mt-3 mb-3">

        </div>
        </div>
        <div class="col-md-2">
        <div class="form-group">
        <label for="" class="mb-3"></label>
        <button class="btn mt-4 mb-2 btn-danger btn-sm removeSubMenu" style="margin-top:44px!important"><i class='fe fe-trash'></i></button>
        </div>
        </div>
        </div>
       `;
        $(submenuContainer).append(subMenuData);
    });
    // To remove sub menus
    $(document).on('click', '.removeSubMenu', function(e){
        e.preventDefault();
        $(this).closest('.row').remove();
    });
    // Function to submit Form
    $(menuForm).submit(function(e){
        e.preventDefault();
        let  isValid  = true;

        if(name.val() == ""){
            toastr['error']("Menu name is required..!");
            isValid  = false;
            return false;
        }
        if(icon.val() == ""){
            toastr['error']("Icon for Menu is required..!");
            isValid  = false;
            return false;
        }
        // Check if any route name is empty
        let sub_name = $(document).find('input[name="sub_menu_name[]"]').map(function () {
            return $(this).val();
        }).get();

        if (sub_name.some(sub_name => sub_name === "")) {
            toastr['error']("Sub-menu is required..!");
            isValid  = false;
            return false;
        }


        let route = $(document).find('input[name="route[]"]').map(function () {
            return $(this).val();
        }).get();

        // Check if any route name is empty
        if (route.some(route => route === "")) {
            toastr['error']("Route Name is Required for all submenus..!");
            isValid = false;
            return false;
        }
        checkRoutes(route , menuCheckroute).then(response =>{

           if(response != true) {
                isValid = false;
                toastr['error'](response);
                return false;
            }
            if(isValid){
                    let id = "";
                if(action == "edit"){
                    id = menusData.id;
                }
                e.preventDefault();
                $.ajax({
                    url : StoreMenuRoute +'/'+ id,
                    type :'POST',
                    data:$(menuForm).serialize(),
                    success:function(response){
                        if(response.success){
                            e.preventDefault();
                            action == "edit" ?toastr['success']("Menu has been successfully Update!") : toastr['success']("Menu has been successfully Created!");
                            setTimeout(() => {
                                location.href = menuIndexUrl ;
                            }, 1500);
                        }
                        else{
                            e.preventDefault();
                            action == "edit" ?toastr['error']("Failed to update menu!"):toastr['error']("Failed to create menu!");
                            return false;
                        }
                    }
                    ,error:function(jqXHR, textStatus, errorThrown){
                        e.preventDefault();
                        toastr['error'](errorThrown);
                        return false;
                    }
                })
            }
        })
        .catch(error => {
            // Handle error
            toastr['error'](error);
            isValid = false;
                return false;
        });


        function checkRoutes(routeName  , UrlForRouteCheck){
            return new Promise((resolve , reject) =>{
                $.ajax({
                    url: UrlForRouteCheck ,
                    type :"Post",
                    data:{ route : routeName , '_token' : $("#csrf-token").val()},
                     success: function (response) {
                            if (response.success) {
                                resolve(true);
                            }
                            if (response.error) {
                                reject(response.error);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            reject(errorThrown);
                        }

                })
            });
        }

    });

    // To Get Icons In Dropdown

    function getIcons(icon) {

        folderPath = '/svg-list';
        var iconDropDown = $(document).find('.iconDropDown');
        iconDropDown.html(`<option value="">Fetching Icons Please Wait..!</option>`);
        $.ajax({
            url : folderPath,
            dataType:'json',
            success:function(data){
                iconDropDown.html(`<option value="${icon ?? ""}"> ${icon ?? "Please Select Icon for menu"}</option>`);

                $.each(data , function(index , item){

                var className = `fe fe-${item.class}`;
                 var  options = $('<option>' , {
                    text:`${item.file}`,
                    value:`fe fe-${item.file}`,
                    'data-class':className
                });
                iconDropDown.append(options);
            });

        iconDropDown.select2({
            templateResult: function(data){
            if(!data.element){
                return data.text;
            }
            var $element = $(data.element);
            var className = $element.data("class");
            var $option = $('<span><i class="' + className + '"></i> ' + data.text + '</span>');
            return $option;
            } ,
            containerCssClass:'form-control mb-3 mt-3',
            width:'100%'
        });
            }
        }) // Ajax Ends here
    };

    // Edit
    if(action == 'edit'){
   
        if(menusData.has_sub == 0){
            $(menu_title).val(menusData.menu_title);
            $(name).val(menusData.name);
            $('input[name="route[]"]').val(menusData.route);
           getIcons(menusData.icon);
        }
        else{
        $(menutitle).val(menusData.menu_title);
        $(name).val(menusData.name);
        $('input[name="route[]"]').val(menusData.route);

        getIcons(menusData.icon);
        $(hasMenuSwitch).prop('checked',true);
        $(menuRoute).find('.menuInputRoute').remove();
        menuContainer.addClass('col-md-6');
        $(menusData.submenu).each(function(index,value){
            let subMenu = "";
            let subMenuData = "";
            let button = `<div class="col-md-2">
            <div class="form-group">
            <label for="" class="mb-3"></label>
            <button class="btn mt-4 mb-2 btn-danger btn-sm removeSubMenu" style="margin-top:44px!important"><i class='fe fe-trash'></i></button>
            </div>
            </div>`;
            if(index === 0){
                button = ` <div class="col-md-2">
                <div class="form-group">
                 <label for="" class="mb-3"></label>
                 <button class="btn mt-4 mb-2 btn-success btn-sm" id="addSubMenu" style="margin-top:44px!important"><i class="fe fe-plus"></i></button>
                </div>
             </div>` ;
            }

                subMenuData  = `
               <div class="row">
               <div class="col-md-5">
               <div class="form-group">
                   <label for="name">Sub-Menu Name</label>
                   <input type="text" name="sub_menu_name[]" placeholder="Enter Sub-Menu Name" value="${value.name}" class="form-control mt-3 mb-3">
               </div>
               </div>
               <div class="col-md-5">
               <div class="form-group">
                   <label for="name">Sub-Menu Route</label>
                   <input type="text" name="route[]" placeholder="Enter Sub-Menu Route" value="${value.route}" class="form-control mt-3 mb-3">

               </div>
               </div>
               ${button}
               </div>
              `;

            $(submenuContainer).append(subMenuData);
            submenuContainer.fadeIn();
        });
       }
    }

});
