<?php
/*
Template Name: Dashboard-Template
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>





    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <nav class="navbar navbar-vertical navbar-expand-lg" >
        <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
          <!-- scrollbar removed-->
          <div class="navbar-vertical-content">
            <ul class="navbar-nav flex-column" id="navbarVerticalNav">
              <li class="nav-item">
                <!-- parent pages-->
                <div class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1" href="#nv-home" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-home">
                    <div class="d-flex align-items-center">
                      <div class="dropdown-indicator-icon-wrapper"><span class="fas fa-caret-right dropdown-indicator-icon"></span></div><span class="nav-link-icon"><span data-feather="pie-chart"></span></span><span class="nav-link-text">Home</span>
                    </div>
                  </a>
                  <div class="parent-wrapper label-1">
                    <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-home">
                      <li class="collapsed-nav-item-title d-none">Home</li>
                      <li class="nav-item"><a class="nav-link" href="../../index.html">
                          <div class="d-flex align-items-center"><span class="nav-link-text">E commerce</span></div>
                        </a><!-- more inner pages-->
                      </li>
                      <li class="nav-item"><a class="nav-link" href="../../dashboard/project-management.html">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Project management</span></div>
                        </a><!-- more inner pages-->
                      </li>
                      <li class="nav-item"><a class="nav-link" href="../../dashboard/crm.html">
                          <div class="d-flex align-items-center"><span class="nav-link-text">CRM</span></div>
                        </a><!-- more inner pages-->
                      </li>
                      <li class="nav-item"><a class="nav-link" href="../../dashboard/travel-agency.html">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Travel agency</span></div>
                        </a><!-- more inner pages-->
                      </li>
                      <li class="nav-item"><a class="nav-link" href="../../dashboard/stock.html">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Stock</span><span class="badge ms-2 badge badge-phoenix badge-phoenix-warning ">new</span></div>
                        </a><!-- more inner pages-->
                      </li>
                      <li class="nav-item"><a class="nav-link" href="../../apps/social/feed.html">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Social feed</span></div>
                        </a><!-- more inner pages-->
                      </li>
                    </ul>
                  </div>
                </div>
              </li>
              <li class="nav-item">
                <!-- label-->
                <p class="navbar-vertical-label">Capture</p>
                <hr class="navbar-vertical-line" /><!-- parent pages-->


                <div class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1" href="#nv-project-management" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="nv-project-management">
                    <div class="d-flex align-items-center">
                      <div class="dropdown-indicator-icon-wrapper"><span class="fas fa-caret-right dropdown-indicator-icon"></span></div><span class="nav-link-icon"><span data-feather="clipboard"></span></span><span class="nav-link-text">Class management</span>
                      <svg class="svg-inline--fa fa-circle text-info ms-1 new-page-indicator" style="font-size: 6px;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z"></path></svg>
                    </div>
                  </a>
                  <div class="parent-wrapper label-1">
                    <ul class="nav collapse parent show" data-bs-parent="#navbarVerticalCollapse" id="nv-project-management">
                      <li class="collapsed-nav-item-title d-none">Project management</li>
                      <li class="nav-item"><a class="nav-link active" href="../../apps/project-management/create-new.html">
                          <div class="d-flex align-items-center"><span class="nav-link-text">Create Class</span><span class="badge ms-2 badge badge-phoenix badge-phoenix-warning nav-link-badge">new</span></div>
                        </a><!-- more inner pages-->
                      </li>
                      <li class="nav-item"><a class="nav-link" href="../../apps/project-management/project-list-view.html">
                          <div class="d-flex align-items-center"><span class="nav-link-text">All Classes</span></div>
                        </a><!-- more inner pages-->
                      </li>
                    </ul>
                  </div>
                </div><!-- parent pages-->




              </li>
            </ul>
          </div>
        </div>
        <div class="navbar-vertical-footer"><button class="btn navbar-vertical-toggle border-0 fw-semibold w-100 white-space-nowrap d-flex align-items-center"><span class="uil uil-left-arrow-to-left fs-8"></span><span class="uil uil-arrow-from-right fs-8"></span><span class="navbar-vertical-footer-text ms-2">Collapsed View</span></button></div>
      </nav>

      <div class="content">
        <nav class="mb-3" aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="#!">Page 1</a></li>
            <li class="breadcrumb-item"><a href="#!">Page 2</a></li>
            <li class="breadcrumb-item active">Default</li>
          </ol>
        </nav>
        <h2 class="mb-4">Create a Class</h2>

<?php  echo do_shortcode( '[wecoza_capture_class]' );?>

<h2 class="mb-4">Create a project</h2>

        <div class="row">
          <div class="col-xl-9">
            <form class="row g-3 mb-6">
              <div class="col-sm-6 col-md-8">
                <div class="form-floating"><input class="form-control" id="floatingInputGrid" type="text" placeholder="Project title" /><label for="floatingInputGrid">Project title</label></div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="form-floating"><select class="form-select" id="floatingSelectTask">
                    <option selected="selected">Select task view</option>
                    <option value="1">technical</option>
                    <option value="2">external</option>
                    <option value="3">organizational</option>
                  </select><label for="floatingSelectTask">Defult task view</label></div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="form-floating"><select class="form-select" id="floatingSelectPrivacy">
                    <option selected="selected">Select privacy</option>
                    <option value="1">Data Privacy One</option>
                    <option value="2">Data Privacy Two</option>
                    <option value="3">Data Privacy Three</option>
                  </select><label for="floatingSelectPrivacy">Project privacy</label></div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="form-floating"><select class="form-select" id="floatingSelectTeam">
                    <option selected="selected">Select team</option>
                    <option value="1">Team One</option>
                    <option value="2">Team Two</option>
                    <option value="3">Team Three</option>
                  </select><label for="floatingSelectTeam">Team </label></div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="form-floating"><select class="form-select" id="floatingSelectAssignees">
                    <option selected="selected">Select assignees </option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                  </select><label for="floatingSelectAssignees">People </label></div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="form-floating"><select class="form-select" id="floatingSelectAdmin">
                    <option selected="selected">Select admin</option>
                    <option value="1">Data Privacy One</option>
                    <option value="2">Data Privacy Two</option>
                    <option value="3">Data Privacy Three</option>
                  </select><label for="floatingSelectAdmin">Project Lead</label></div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="flatpickr-input-container">
                  <div class="form-floating"><input class="form-control datetimepicker" id="floatingInputStartDate" type="text" placeholder="end date" data-options='{"disableMobile":true}' /><label class="ps-6" for="floatingInputStartDate">Start date</label><span class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span></div>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="flatpickr-input-container">
                  <div class="form-floating"><input class="form-control datetimepicker" id="floatingInputDeadline" type="text" placeholder="deadline" data-options='{"disableMobile":true}' /><label class="ps-6" for="floatingInputDeadline">Deadline</label><span class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span></div>
                </div>
              </div>
              <div class="col-12 gy-6">
                <div class="form-floating"><textarea class="form-control" id="floatingProjectOverview" placeholder="Leave a comment here" style="height: 100px"></textarea><label for="floatingProjectOverview">project overview</label></div>
              </div>
              <div class="col-md-6 gy-6">
                <div class="form-floating"><select class="form-select" id="floatingSelectClient">
                    <option selected="selected">Select client</option>
                    <option value="1">Client One</option>
                    <option value="2">Client Two</option>
                    <option value="3">Client Three</option>
                  </select><label for="floatingSelectClient">client</label></div>
              </div>
              <div class="col-md-6 gy-6">
                <div class="form-floating"><input class="form-control" id="floatingInputBudget" type="text" placeholder="Budget" /><label for="floatingInputBudget">Budget</label></div>
              </div>
              <div class="col-12 gy-6">
                <div class="form-floating form-floating-advance-select"><label>Add tags</label><select class="form-select" id="organizerMultiple" data-choices="data-choices" multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}'>
                    <option selected="selected">Stupidity</option>
                    <option>Jerry</option>
                    <option>Not_the_mouse</option>
                    <option>Rick</option>
                    <option>Biology</option>
                    <option>Neurology</option>
                    <option>Brainlessness</option>
                  </select></div>
              </div>
              <div class="col-12 gy-6">
                <div class="row g-3 justify-content-end">
                  <div class="col-auto"><button class="btn btn-phoenix-primary px-5">Cancel</button></div>
                  <div class="col-auto"><button class="btn btn-primary px-5 px-sm-15">Create Project</button></div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <footer class="footer position-absolute">
          <div class="row g-0 justify-content-between align-items-center h-100">
            <div class="col-12 col-sm-auto text-center">
              <p class="mb-0 mt-2 mt-sm-0 text-body">Thank you for creating with Phoenix<span class="d-none d-sm-inline-block"></span><span class="d-none d-sm-inline-block mx-1">|</span><br class="d-sm-none" />2025 &copy;<a class="mx-1" href="https://themewagon.com">Themewagon</a></p>
            </div>
            <div class="col-12 col-sm-auto text-center">
              <p class="mb-0 text-body-tertiary text-opacity-85">v1.22.0</p>
            </div>
          </div>
        </footer>
      </div>


<div class="support-chat-container">
  <div class="container-fluid support-chat">
    <div class="card bg-body-emphasis">
      <div class="card-header d-flex flex-between-center px-4 py-3 border-bottom border-translucent">
        <h5 class="mb-0 d-flex align-items-center gap-2">
          Support Ticket<span class="fa-solid fa-circle text-success fs-11"></span>
        </h5>
      </div>
      <div class="card-body chat p-0">
        <div class="d-flex flex-column-reverse scrollbar h-100 p-3">
          <div class="text-end mt-6">
            <a
              class="mb-2 d-inline-flex align-items-center text-decoration-none text-body-emphasis bg-body-hover rounded-pill border border-primary py-2 ps-4 pe-3"
              href="#!"
            >
              <p class="mb-0 fw-semibold fs-9">I'm not able to login.</p>
              <span class="fa-solid fa-paper-plane text-primary fs-9 ms-3"></span>
            </a>
            <a
              class="mb-2 d-inline-flex align-items-center text-decoration-none text-body-emphasis bg-body-hover rounded-pill border border-primary py-2 ps-4 pe-3"
              href="#!"
            >
              <p class="mb-0 fw-semibold fs-9">I'm not able to Edit or Update fields.</p>
              <span class="fa-solid fa-paper-plane text-primary fs-9 ms-3"></span>
            </a>
            <a
              class="mb-2 d-inline-flex align-items-center text-decoration-none text-body-emphasis bg-body-hover rounded-pill border border-primary py-2 ps-4 pe-3"
              href="#!"
            >
              <p class="mb-0 fw-semibold fs-9">I'm getting Error Messages.</p>
              <span class="fa-solid fa-paper-plane text-primary fs-9 ms-3"></span>
            </a>
            <a
              class="false d-inline-flex align-items-center text-decoration-none text-body-emphasis bg-body-hover rounded-pill border border-primary py-2 ps-4 pe-3"
              href="#!"
            >
              <p class="mb-0 fw-semibold fs-9">Other Issues.</p>
              <span class="fa-solid fa-paper-plane text-primary fs-9 ms-3"></span>
            </a>
          </div>
          <div class="text-center mt-auto">
            <div class="avatar avatar-3xl status-online">
              <img
                class="rounded-circle border border-3 border-light-subtle"
                src="https://scontent-cpt1-1.xx.fbcdn.net/v/t1.6435-1/96672703_10159734336813496_6079313520707502080_n.jpg?stp=dst-jpg_s480x480_tt6&_nc_cat=111&ccb=1-7&_nc_sid=e99d92&_nc_ohc=OIW8Nqxv9kQQ7kNvwGFGjVw&_nc_oc=Adl_6GcHtNe1wfdLlipJp1_cwAJP7o5pIeaNN3BEuQYW6OR3VWb9HM1HDROscZXa-l4&_nc_zt=24&_nc_ht=scontent-cpt1-1.xx&_nc_gid=gqPvUAnz73rcCpzRfbUX3A&oh=00_AfINy61Yh4Ua77QFHC_pdbHyMgT4C8tvKZ2uy0oICCWdbg&oe=684AC774"
                alt="Support Agent"
              />
            </div>
            <h5 class="mt-2 mb-3">John</h5>
            <p class="text-center text-body-emphasis mb-0">
              Welcome to Company Support – we’ll respond via email ASAP!
            </p>
          </div>
        </div>
      </div>
      <div
        class="card-footer d-flex align-items-center gap-2 border-top border-translucent ps-3 pe-4 py-3"
      >
        <div
          class="d-flex align-items-center flex-1 gap-3 border border-translucent rounded-pill px-4"
        >
          <input
            class="form-control outline-none border-0 flex-1 fs-9 px-0"
            type="text"
            placeholder="Give as much details as possible"
          />
          <label
            class="btn btn-link d-flex p-0 text-body-quaternary fs-9 border-0"
            for="supportChatPhotos"
          >
            <span class="fa-solid fa-image"></span>
          </label>
          <input
            class="d-none"
            type="file"
            accept="image/*"
            id="supportChatPhotos"
          />
          <label
            class="btn btn-link d-flex p-0 text-body-quaternary fs-9 border-0"
            for="supportChatAttachment"
          >
            <span class="fa-solid fa-paperclip"></span>
          </label>
          <input class="d-none" type="file" id="supportChatAttachment" />
        </div>
        <button class="btn p-0 border-0 send-btn">
          <span class="fa-solid fa-paper-plane fs-9"></span>
        </button>
      </div>
    </div>
  </div>
  <button class="btn btn-support-chat p-0 border border-translucent">
    <span class="fs-8 btn-text text-primary text-nowrap">Support.</span>
    <span
      class="ping-icon-wrapper mt-n4 ms-n6 mt-sm-0 ms-sm-2 position-absolute position-sm-relative"
    >
      <span class="ping-icon-bg"></span>
      <span class="fa-solid fa-circle ping-icon"></span>
    </span>
    <span class="fa-solid fa-headset text-primary fs-8 d-sm-none"></span>
    <span class="fa-solid fa-chevron-down text-primary fs-7"></span>
  </button>
</div>




    </main><!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->







<?php 
get_footer();