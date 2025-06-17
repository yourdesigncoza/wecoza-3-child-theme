<?php
/**
 * Sidebar Menu View
 *
 * This view displays the sidebar navigation menu using the Bootstrap_Sidebar_Walker
 *
 * @package WeCoza
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

use WeCoza\Walkers\Bootstrap_Sidebar_Walker;
?>

<nav class="navbar navbar-vertical navbar-expand-lg">
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content">
            <?php
            // Check if the sidebar menu exists
            if (has_nav_menu('sidebar-menu')) {
                // Render the menu
                wp_nav_menu([
                    'theme_location' => 'sidebar-menu',
                    'container' => false,
                    'menu_class' => 'navbar-nav flex-column',
                    'fallback_cb' => false,
                    'walker' => new Bootstrap_Sidebar_Walker()
                ]);
            } else {
                // Display a message if the menu doesn't exist
                echo '<div class="alert alert-info">Please create a menu and assign it to the "Sidebar Menu" location.</div>';
            }
            ?>
        </div>
    </div>
    <div class="navbar-vertical-footer">
      
      <div class="support-chat-container show">
        <div class="container-fluid support-chat">
          <div class="card bg-body-emphasis">
            <div class="card-header d-flex flex-between-center px-4 py-3 border-bottom border-translucent">
              <h5 class="mb-0 d-flex align-items-center gap-2">Support <span class="fa-solid fa-circle text-success fs-11"></span></h5>
              <button class="btn btn-support-chat p-0 border border-translucent btn-chat-close"  data-bs-toggle="modal" data-bs-target="#exampleModal"></span><span class="fa-solid fa-chevron-down text-primary fs-7"></span></button>
            </div>
               <div class="card-body chat p-0">
                  <div class="d-flex flex-column-reverse scrollbar h-100 p-3">
                     <div class="text-end mt-6">
                        <a class="mb-2 d-inline-flex align-items-center text-decoration-none text-body-emphasis bg-body-hover rounded-pill border border-primary py-2 ps-4 pe-3" href="#!">
                           <p class="mb-0 fw-semibold fs-9">I need help with something</p>
                           <span class="fa-solid fa-paper-plane text-primary fs-9 ms-3"></span>
                        </a>
                        <div class-"clearfix"></div>
                        <a class="mb-2 d-inline-flex align-items-center text-decoration-none text-body-emphasis bg-body-hover rounded-pill border border-primary py-2 ps-4 pe-3" href="#!">
                           <p class="mb-0 fw-semibold fs-9">I can’t capture a class / learner etc.</p>
                           <span class="fa-solid fa-paper-plane text-primary fs-9 ms-3"></span>
                        </a>
                        <div class="clearfix"></div>
                        <a class="mb-2 d-inline-flex align-items-center text-decoration-none text-body-emphasis bg-body-hover rounded-pill border border-primary py-2 ps-4 pe-3" href="#!">
                           <p class="mb-0 fw-semibold fs-9">I get system errors.</p>
                           <span class="fa-solid fa-paper-plane text-primary fs-9 ms-3"></span>
                        </a>
                        <div class="clearfix"></div>
                        <a class="false d-inline-flex align-items-center text-decoration-none text-body-emphasis bg-body-hover rounded-pill border border-primary py-2 ps-4 pe-3" href="#!">
                           <p class="mb-0 fw-semibold fs-9">I'm not able to login</p>
                           <span class="fa-solid fa-paper-plane text-primary fs-9 ms-3"></span>
                        </a>
                        <div class="clearfix"></div>
                     </div>
                     <div class="text-center mt-auto">
                        <div class="avatar avatar-3xl status-online"><img class="rounded-circle border border-3 border-light-subtle" src="https://yourdesign.co.za/yd2020/wp-content/uploads/2022/04/profile-150x150.jpg" alt=""></div>
                        <h5 class="mt-2 mb-3">John</h5>
                        <p class="text-center text-body-emphasis mb-0">Have a Technical Issue ~ We will reply ASAP!</p>
                     </div>
                  </div>
               </div>
            <div class="card-footer d-flex align-items-center gap-2 border-top border-translucent ps-3 pe-4 py-3">
              <div class="d-flex align-items-center flex-1 gap-3 border border-translucent rounded-pill px-4"><input class="form-control outline-none border-0 flex-1 fs-9 px-0" type="text" placeholder="Write message"><label class="btn btn-link d-flex p-0 text-body-quaternary fs-9 border-0" for="supportChatPhotos"><span class="fa-solid fa-image"></span></label><input class="d-none" type="file" accept="image/*" id="supportChatPhotos"><label class="btn btn-link d-flex p-0 text-body-quaternary fs-9 border-0" for="supportChatAttachment"> <span class="fa-solid fa-paperclip"></span></label><input class="d-none" type="file" id="supportChatAttachment"></div><button class="btn p-0 border-0 send-btn"><span class="fa-solid fa-paper-plane fs-9"></span></button>
            </div>
          </div>
        </div><button class="btn btn-support-chat p-0 border border-translucent"><span class="fs-8 btn-text text-primary text-nowrap">Support</span><span class="ping-icon-wrapper mt-n4 ms-n6 mt-sm-0 ms-sm-2 position-absolute position-sm-relative"><span class="ping-icon-bg"></span><span class="fa-solid fa-circle ping-icon"></span></span><span class="fa-solid fa-headset text-primary fs-8 d-sm-none"></span><span class="fa-solid fa-chevron-down text-primary fs-7"></span></button>
      </div>
    </div>
</nav>
