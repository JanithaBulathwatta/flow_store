
<div class="main-content app-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-9">
				<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
					<h1 class="page-title fw-semibold fs-18 mb-0">System Permission Settings</h1>
				</div>
				<div class="card custom-card">

					<!-- USER TYPE TABS -->
					<ul id="userTypeTabs"
						class="nav nav-tabs tab-style-8 scaleX rounded m-3 mb-0 profile-settings-tab gap-3">
					</ul>

					<!-- TAB CONTENT -->
					<div id="tabContent" class="p-3 tab-content"></div>

				</div>

			</div>
		</div>
	</div>
</div>

<script>

$(document).ready(function () {

    loadPermissions();

});


/* LOAD PERMISSIONS */
function loadPermissions()
{
    $.get("/Settings/getPermissionData", function (res) {

        let tabs = "";
        let content = "";
        let i = 0;

        res.user_types.forEach(function (ut) {

            let active = i === 0 ? "active" : "";
            let show = i === 0 ? "show active" : "";

            tabs += `
                <li class="nav-item">
                    <a class="nav-link fs-16 fw-medium ${active}"
                       data-bs-toggle="tab"
                       href="#ut${ut.ut_id}">
                       ${ut.ut_name}
                    </a>
                </li>
            `;

            content += `
            <div class="tab-pane fade ${show}" id="ut${ut.ut_id}">
                <form class="permForm" data-ut="${ut.ut_id}">

                    ${buildModules(res.modules, res.permissions[ut.ut_id])}

                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-primary btn-sm savePerm">
                            Save Permissions
                        </button>
                    </div>

                </form>
            </div>
            `;

            i++;

        });

        $("#userTypeTabs").html(tabs);
        $("#tabContent").html(content);

    }, "json");
}


function buildModules(modules, permissions)
{
    if (!modules || Object.keys(modules).length === 0) {

        return `
        <div class="alert alert-warning mt-3">
            No modules assigned for this user type.
        </div>
        `;

    }

    modules = Object.values(modules);

    let html = "";

    modules.forEach(function(mod){

        /* MAIN MODULE HEADER */
        html += `
        <div class="mt-4 p-2 bg-light fw-semibold justify-content-between align-items-center mb-4 flex-wrap gap-1 p-2 bg-primary rounded text-white">
            ${mod.name}
        </div>
        `;
		
        if(mod.subs && mod.subs.length > 0){

            html += `<div class="row gx-4 gy-3">`;

            mod.subs.forEach(function(sub){

                let checked = false;

                if(permissions &&
                   permissions[mod.pm_id] &&
                   permissions[mod.pm_id].includes(sub.ps_id))
                {
                    checked = true;
                }

                let onClass = checked ? "on" : "";

                html += `
                <div class="col-xl-6">

                    <div class="d-flex align-items-center justify-content-between 
                                px-3 py-2 border rounded">

                        <div>
                            <p class="fs-14 mb-1 fw-medium">${sub.ps_name}</p>
                            <p class="fs-12 mb-0 text-muted">
                                Allow access to ${sub.ps_name.toLowerCase()}
                            </p>
                        </div>

                        <div class="toggle toggle-success ${onClass} permToggle"
                             data-pm="${mod.pm_id}"
                             data-ps="${sub.ps_id}">
                             <span></span>
                        </div>

                    </div>

                </div>
                `;

            });

            html += `</div>`;
        }

    });

    return html;
}



/* TOGGLE CLICK */
$(document).on("click", ".permToggle", function(){
    $(this).toggleClass("on");
});



/* SAVE PERMISSIONS */
$(document).on("click", ".savePerm", function(){

    let form  = $(this).closest(".permForm");
    let ut_id = form.data("ut");

    let permissions = [];

    form.find(".permToggle.on").each(function(){

        permissions.push({
            pm_id : $(this).data("pm"),
            ps_id : $(this).data("ps")
        });

    });

    $.post("/Settings/save",
    {
        ut_id : ut_id,
        permissions : permissions
    },
    function(res){

        if(res.status === "success"){
            toastr.success("Permissions saved successfully");
            loadPermissions();
        }
        else{
            toastr.error("Error saving permissions");
        }

    },"json");

});


</script>