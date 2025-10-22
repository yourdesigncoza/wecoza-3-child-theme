<?php
   /*
   Template Name: Dashboard-Template
   */
   
   if ( ! defined( 'ABSPATH' ) ) {
   	exit; // Exit if accessed directly.
   }
   
   get_header(); ?>
<style>
   /* Simple timeline styling */
   .timeline {
   position: relative;
   padding-left: 1.5rem;
   list-style: none;
   }
   .timeline::before {
   content: "";
   position: absolute;
   left: 0.65rem;
   top: 0;
   bottom: 0;
   width: 2px;
   background: #dee2e6;
   }
   .timeline-item {
   position: relative;
   margin-bottom: 1.5rem;
   padding-left: 1.5rem;
   }
   .timeline-item::before {
   content: "";
   position: absolute;
   left: -0.15rem;
   top: 0.25rem;
   width: 0.75rem;
   height: 0.75rem;
   border-radius: 50%;
   background: #0d6efd;
   }
</style>
<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->
<main class="main" id="top">
   <div class="content">
   <h2 class="mb-4">Demo APP Landing</h2>
   <div class="col-6">
      <div class="card border h-100 w-100 overflow-hidden">
         <div class="bg-holder d-block bg-card" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/spot-illustrations/32.png);background-position: top right;"></div>
         <!--/.bg-holder-->
         <div class="d-dark-none">
            <div class="bg-holder d-none d-sm-block d-xl-none d-xxl-block bg-card" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/spot-illustrations/21.png);background-position: bottom right; background-size: auto;"></div>
            <!--/.bg-holder-->
         </div>
         <div class="d-light-none">
            <div class="bg-holder d-none d-sm-block d-xl-none d-xxl-block bg-card" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/spot-illustrations/dark_21.png);background-position: bottom right; background-size: auto;"></div>
            <!--/.bg-holder-->
         </div>
         <div class="card-body px-5 position-relative">
            <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4"><span class="fw-bold">Coming soon</span><span class="fa-solid fa-award ms-1"></span></div>
            <h3 class="mb-5">Project Pulse: Real-Time Progress at a Glance</h3>
            <p class="text-body-tertiary fw-semibold d-sm-block" style="max-width: 80%;">We've turned every behind-the-scenes commit, fix and feature into a clear story your whole team can follow. The new DevAI Activity Timeline automatically converts daily reports into friendly, time-stamped updates complete with intuitive icons, plain-language summaries and milestone highlights. No more digging through tickets or spreadsheets; you get a live, shareable snapshot of what's been shipped, what's coming next and how each improvement benefits your users. Transparency for you.</p>
         </div>
         <div class="card-footer border-0 py-0 px-5 z-1">
            <p class="text-body-tertiary fw-semibold">Follow <a href="https://devai.co.za">DevAi </a> For updates.</p>
         </div>
      </div>
   </div>
   <div class="row mt-3 g-3">
      <div class="col-12 col-xl-6 col-xxl-7">
         <div class="card todo-list h-100">
            <div class="card-header border-bottom-0 pb-0">
               <div class="row justify-content-between align-items-center mb-4">
                  <div class="col-auto">
                     <h3 class="text-body-emphasis">To do</h3>
                     <p class="mb-2 mb-md-0 mb-lg-2 text-body-tertiary">Task assigned to me</p>
                  </div>
                  <div class="col-auto w-100 w-md-auto">
                     <div class="row align-items-center g-0 justify-content-between">
                        <div class="col-12 col-sm-auto">
                           <div class="search-box w-100 mb-2 mb-sm-0" style="max-width:30rem;">
                              <form class="position-relative">
                                 <input class="form-control search-input search" type="search" placeholder="Search tasks" aria-label="Search">
                                 <svg class="svg-inline--fa fa-magnifying-glass search-box-icon" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="magnifying-glass" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path>
                                 </svg>
                                 <!-- <span class="fas fa-search search-box-icon"></span> Font Awesome fontawesome.com -->
                              </form>
                           </div>
                        </div>
                        <div class="col-auto d-flex">
                           <p class="mb-0 ms-sm-3 fs-9 text-body-tertiary fw-bold">
                              <svg class="svg-inline--fa fa-filter me-1 fw-extra-bold fs-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="filter" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                 <path fill="currentColor" d="M3.9 54.9C10.5 40.9 24.5 32 40 32H472c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z"></path>
                              </svg>
                              <!-- <span class="fas fa-filter me-1 fw-extra-bold fs-10"></span> Font Awesome fontawesome.com -->23 tasks
                           </p>
                           <button class="btn btn-link p-0 ms-3 fs-9 text-primary fw-bold">
                              <svg class="svg-inline--fa fa-sort me-1 fw-extra-bold fs-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="sort" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                 <path fill="currentColor" d="M137.4 41.4c12.5-12.5 32.8-12.5 45.3 0l128 128c9.2 9.2 11.9 22.9 6.9 34.9s-16.6 19.8-29.6 19.8H32c-12.9 0-24.6-7.8-29.6-19.8s-2.2-25.7 6.9-34.9l128-128zm0 429.3l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128c-12.5 12.5-32.8 12.5-45.3 0z"></path>
                              </svg>
                              <!-- <span class="fas fa-sort me-1 fw-extra-bold fs-10"></span> Font Awesome fontawesome.com -->Sorting
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="card-body py-0 scrollbar to-do-list-body">
               <div class="d-flex hover-actions-trigger py-3 border-translucent border-top">
                  <input class="form-check-input form-check-input-todolist flex-shrink-0 my-1 me-2 form-check-input-undefined" type="checkbox" id="checkbox-todo-0" data-event-propagation-prevent="data-event-propagation-prevent">
                  <div class="row justify-content-between align-items-md-center btn-reveal-trigger border-translucent gx-0 flex-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#exampleModal">
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="mb-1 mb-md-0 d-flex align-items-center lh-1"><label class="form-check-label mb-1 mb-md-0 mb-xl-1 mb-xxl-0 fs-8 me-2 line-clamp-1 text-body cursor-pointer">Designing the dungeon</label><span class="badge badge-phoenix ms-auto fs-10 badge-phoenix-primary">DRAFT</span></div>
                     </div>
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="d-flex lh-1 align-items-center">
                           <a class="text-body-tertiary fw-bold fs-10 me-2" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                              <svg class="svg-inline--fa fa-paperclip me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="paperclip" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                 <path fill="currentColor" d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z"></path>
                              </svg>
                              <!-- <span class="fas fa-paperclip me-1"></span> Font Awesome fontawesome.com -->2
                           </a>
                           <p class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 me-xl-2 me-xxl-3 mb-0">12 Nov, 2021</p>
                           <div class="hover-md-hide hover-xl-show hover-xxl-hide">
                              <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0 ps-md-3 ps-xl-0 ps-xxl-3 border-start-md border-xl-0 border-start-xxl">12:00 PM</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="d-none d-md-block d-xl-none d-xxl-block end-0 position-absolute" style="top: 23%;" data-event-propagation-prevent="data-event-propagation-prevent">
                     <div class="hover-actions end-0" data-event-propagation-prevent="data-event-propagation-prevent">
                        <button class="btn btn-phoenix-secondary btn-icon me-1 fs-10 text-body px-0 me-1" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-pen-to-square" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen-to-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path>
                           </svg>
                           <!-- <span class="fas fa-edit"></span> Font Awesome fontawesome.com -->
                        </button>
                        <button class="btn btn-phoenix-secondary btn-icon fs-10 text-danger px-0" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                           </svg>
                           <!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com -->
                        </button>
                     </div>
                  </div>
               </div>
               <div class="d-flex hover-actions-trigger py-3 border-translucent border-top">
                  <input class="form-check-input form-check-input-todolist flex-shrink-0 my-1 me-2 form-check-input-undefined" type="checkbox" id="checkbox-todo-1" data-event-propagation-prevent="data-event-propagation-prevent">
                  <div class="row justify-content-between align-items-md-center btn-reveal-trigger border-translucent gx-0 flex-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#exampleModal">
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="mb-1 mb-md-0 d-flex align-items-center lh-1"><label class="form-check-label mb-1 mb-md-0 mb-xl-1 mb-xxl-0 fs-8 me-2 line-clamp-1 text-body cursor-pointer">Hiring a motion graphic designer</label><span class="badge badge-phoenix ms-auto fs-10 badge-phoenix-warning">URGENT</span></div>
                     </div>
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="d-flex lh-1 align-items-center">
                           <a class="text-body-tertiary fw-bold fs-10 me-2" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                              <svg class="svg-inline--fa fa-paperclip me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="paperclip" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                 <path fill="currentColor" d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z"></path>
                              </svg>
                              <!-- <span class="fas fa-paperclip me-1"></span> Font Awesome fontawesome.com -->2
                           </a>
                           <a class="text-warning fw-bold fs-10 me-2" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                              <svg class="svg-inline--fa fa-list-check me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="list-check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                 <path fill="currentColor" d="M152.1 38.2c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 113C-2.3 103.6-2.3 88.4 7 79s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zm0 160c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 273c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zM224 96c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zm0 160c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zM160 416c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H192c-17.7 0-32-14.3-32-32zM48 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"></path>
                              </svg>
                              <!-- <span class="fas fa-tasks me-1"></span> Font Awesome fontawesome.com -->3
                           </a>
                           <p class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 me-xl-2 me-xxl-3 mb-0">12 Nov, 2021</p>
                           <div class="hover-md-hide hover-xl-show hover-xxl-hide">
                              <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0 ps-md-3 ps-xl-0 ps-xxl-3 border-start-md border-xl-0 border-start-xxl">12:00 PM</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="d-none d-md-block d-xl-none d-xxl-block end-0 position-absolute" style="top: 23%;" data-event-propagation-prevent="data-event-propagation-prevent">
                     <div class="hover-actions end-0" data-event-propagation-prevent="data-event-propagation-prevent">
                        <button class="btn btn-phoenix-secondary btn-icon me-1 fs-10 text-body px-0 me-1" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-pen-to-square" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen-to-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path>
                           </svg>
                           <!-- <span class="fas fa-edit"></span> Font Awesome fontawesome.com -->
                        </button>
                        <button class="btn btn-phoenix-secondary btn-icon fs-10 text-danger px-0" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                           </svg>
                           <!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com -->
                        </button>
                     </div>
                  </div>
               </div>
               <div class="d-flex hover-actions-trigger py-3 border-translucent border-top">
                  <input class="form-check-input form-check-input-todolist flex-shrink-0 my-1 me-2 form-check-input-undefined" type="checkbox" id="checkbox-todo-2" data-event-propagation-prevent="data-event-propagation-prevent">
                  <div class="row justify-content-between align-items-md-center btn-reveal-trigger border-translucent gx-0 flex-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#exampleModal">
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="mb-1 mb-md-0 d-flex align-items-center lh-1"><label class="form-check-label mb-1 mb-md-0 mb-xl-1 mb-xxl-0 fs-8 me-2 line-clamp-1 text-body cursor-pointer">Daily Meetings Purpose, participants</label><span class="badge badge-phoenix ms-auto fs-10 badge-phoenix-info">ON PROCESS</span></div>
                     </div>
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="d-flex lh-1 align-items-center">
                           <a class="text-body-tertiary fw-bold fs-10 me-2" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                              <svg class="svg-inline--fa fa-paperclip me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="paperclip" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                 <path fill="currentColor" d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z"></path>
                              </svg>
                              <!-- <span class="fas fa-paperclip me-1"></span> Font Awesome fontawesome.com -->4
                           </a>
                           <p class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 me-xl-2 me-xxl-3 mb-0">12 Dec, 2021</p>
                           <div class="hover-md-hide hover-xl-show hover-xxl-hide">
                              <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0 ps-md-3 ps-xl-0 ps-xxl-3 border-start-md border-xl-0 border-start-xxl">05:00 AM</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="d-none d-md-block d-xl-none d-xxl-block end-0 position-absolute" style="top: 23%;" data-event-propagation-prevent="data-event-propagation-prevent">
                     <div class="hover-actions end-0" data-event-propagation-prevent="data-event-propagation-prevent">
                        <button class="btn btn-phoenix-secondary btn-icon me-1 fs-10 text-body px-0 me-1" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-pen-to-square" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen-to-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path>
                           </svg>
                           <!-- <span class="fas fa-edit"></span> Font Awesome fontawesome.com -->
                        </button>
                        <button class="btn btn-phoenix-secondary btn-icon fs-10 text-danger px-0" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                           </svg>
                           <!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com -->
                        </button>
                     </div>
                  </div>
               </div>
               <div class="d-flex hover-actions-trigger py-3 border-translucent border-top">
                  <input class="form-check-input form-check-input-todolist flex-shrink-0 my-1 me-2 form-check-input-undefined" type="checkbox" id="checkbox-todo-3" data-event-propagation-prevent="data-event-propagation-prevent">
                  <div class="row justify-content-between align-items-md-center btn-reveal-trigger border-translucent gx-0 flex-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#exampleModal">
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="mb-1 mb-md-0 d-flex align-items-center lh-1"><label class="form-check-label mb-1 mb-md-0 mb-xl-1 mb-xxl-0 fs-8 me-2 line-clamp-1 text-body cursor-pointer">Finalizing the geometric shapes</label></div>
                     </div>
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="d-flex lh-1 align-items-center">
                           <a class="text-body-tertiary fw-bold fs-10 me-2" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                              <svg class="svg-inline--fa fa-paperclip me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="paperclip" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                 <path fill="currentColor" d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z"></path>
                              </svg>
                              <!-- <span class="fas fa-paperclip me-1"></span> Font Awesome fontawesome.com -->3
                           </a>
                           <p class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 me-xl-2 me-xxl-3 mb-0">12 Nov, 2021</p>
                           <div class="hover-md-hide hover-xl-show hover-xxl-hide">
                              <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0 ps-md-3 ps-xl-0 ps-xxl-3 border-start-md border-xl-0 border-start-xxl">12:00 PM</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="d-none d-md-block d-xl-none d-xxl-block end-0 position-absolute" style="top: 23%;" data-event-propagation-prevent="data-event-propagation-prevent">
                     <div class="hover-actions end-0" data-event-propagation-prevent="data-event-propagation-prevent">
                        <button class="btn btn-phoenix-secondary btn-icon me-1 fs-10 text-body px-0 me-1" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-pen-to-square" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen-to-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path>
                           </svg>
                           <!-- <span class="fas fa-edit"></span> Font Awesome fontawesome.com -->
                        </button>
                        <button class="btn btn-phoenix-secondary btn-icon fs-10 text-danger px-0" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                           </svg>
                           <!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com -->
                        </button>
                     </div>
                  </div>
               </div>
               <div class="d-flex hover-actions-trigger py-3 border-translucent border-top">
                  <input class="form-check-input form-check-input-todolist flex-shrink-0 my-1 me-2 form-check-input-undefined" type="checkbox" id="checkbox-todo-4" data-event-propagation-prevent="data-event-propagation-prevent">
                  <div class="row justify-content-between align-items-md-center btn-reveal-trigger border-translucent gx-0 flex-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#exampleModal">
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="mb-1 mb-md-0 d-flex align-items-center lh-1"><label class="form-check-label mb-1 mb-md-0 mb-xl-1 mb-xxl-0 fs-8 me-2 line-clamp-1 text-body cursor-pointer">Daily meeting with team members</label></div>
                     </div>
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="d-flex lh-1 align-items-center">
                           <p class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 me-xl-2 me-xxl-3 mb-0">1 Nov, 2021</p>
                           <div class="hover-md-hide hover-xl-show hover-xxl-hide">
                              <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0 ps-md-3 ps-xl-0 ps-xxl-3 border-start-md border-xl-0 border-start-xxl">12:00 PM</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="d-none d-md-block d-xl-none d-xxl-block end-0 position-absolute" style="top: 23%;" data-event-propagation-prevent="data-event-propagation-prevent">
                     <div class="hover-actions end-0" data-event-propagation-prevent="data-event-propagation-prevent">
                        <button class="btn btn-phoenix-secondary btn-icon me-1 fs-10 text-body px-0 me-1" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-pen-to-square" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen-to-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path>
                           </svg>
                           <!-- <span class="fas fa-edit"></span> Font Awesome fontawesome.com -->
                        </button>
                        <button class="btn btn-phoenix-secondary btn-icon fs-10 text-danger px-0" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                           </svg>
                           <!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com -->
                        </button>
                     </div>
                  </div>
               </div>
               <div class="d-flex hover-actions-trigger py-3 border-translucent border-top">
                  <input class="form-check-input form-check-input-todolist flex-shrink-0 my-1 me-2 form-check-input-undefined" type="checkbox" id="checkbox-todo-5" data-event-propagation-prevent="data-event-propagation-prevent">
                  <div class="row justify-content-between align-items-md-center btn-reveal-trigger border-translucent gx-0 flex-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#exampleModal">
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="mb-1 mb-md-0 d-flex align-items-center lh-1"><label class="form-check-label mb-1 mb-md-0 mb-xl-1 mb-xxl-0 fs-8 me-2 line-clamp-1 text-body cursor-pointer">Daily Standup Meetings</label></div>
                     </div>
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="d-flex lh-1 align-items-center">
                           <a class="text-warning fw-bold fs-10 me-2" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                              <svg class="svg-inline--fa fa-list-check me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="list-check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                 <path fill="currentColor" d="M152.1 38.2c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 113C-2.3 103.6-2.3 88.4 7 79s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zm0 160c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 273c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zM224 96c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zm0 160c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zM160 416c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H192c-17.7 0-32-14.3-32-32zM48 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"></path>
                              </svg>
                              <!-- <span class="fas fa-tasks me-1"></span> Font Awesome fontawesome.com -->4
                           </a>
                           <p class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 me-xl-2 me-xxl-3 mb-0">13 Nov, 2021</p>
                           <div class="hover-md-hide hover-xl-show hover-xxl-hide">
                              <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0 ps-md-3 ps-xl-0 ps-xxl-3 border-start-md border-xl-0 border-start-xxl">10:00 PM</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="d-none d-md-block d-xl-none d-xxl-block end-0 position-absolute" style="top: 23%;" data-event-propagation-prevent="data-event-propagation-prevent">
                     <div class="hover-actions end-0" data-event-propagation-prevent="data-event-propagation-prevent">
                        <button class="btn btn-phoenix-secondary btn-icon me-1 fs-10 text-body px-0 me-1" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-pen-to-square" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen-to-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path>
                           </svg>
                           <!-- <span class="fas fa-edit"></span> Font Awesome fontawesome.com -->
                        </button>
                        <button class="btn btn-phoenix-secondary btn-icon fs-10 text-danger px-0" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                           </svg>
                           <!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com -->
                        </button>
                     </div>
                  </div>
               </div>
               <div class="d-flex hover-actions-trigger py-3 border-translucent border-top">
                  <input class="form-check-input form-check-input-todolist flex-shrink-0 my-1 me-2 form-check-input-undefined" type="checkbox" id="checkbox-todo-6" data-event-propagation-prevent="data-event-propagation-prevent">
                  <div class="row justify-content-between align-items-md-center btn-reveal-trigger border-translucent gx-0 flex-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#exampleModal">
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="mb-1 mb-md-0 d-flex align-items-center lh-1"><label class="form-check-label mb-1 mb-md-0 mb-xl-1 mb-xxl-0 fs-8 me-2 line-clamp-1 text-body cursor-pointer">Procrastinate for a month</label><span class="badge badge-phoenix ms-auto fs-10 badge-phoenix-info">ON PROCESS</span></div>
                     </div>
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="d-flex lh-1 align-items-center">
                           <a class="text-body-tertiary fw-bold fs-10 me-2" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                              <svg class="svg-inline--fa fa-paperclip me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="paperclip" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                 <path fill="currentColor" d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z"></path>
                              </svg>
                              <!-- <span class="fas fa-paperclip me-1"></span> Font Awesome fontawesome.com -->3
                           </a>
                           <p class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 me-xl-2 me-xxl-3 mb-0">12 Nov, 2021</p>
                           <div class="hover-md-hide hover-xl-show hover-xxl-hide">
                              <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0 ps-md-3 ps-xl-0 ps-xxl-3 border-start-md border-xl-0 border-start-xxl">12:00 PM</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="d-none d-md-block d-xl-none d-xxl-block end-0 position-absolute" style="top: 23%;" data-event-propagation-prevent="data-event-propagation-prevent">
                     <div class="hover-actions end-0" data-event-propagation-prevent="data-event-propagation-prevent">
                        <button class="btn btn-phoenix-secondary btn-icon me-1 fs-10 text-body px-0 me-1" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-pen-to-square" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen-to-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path>
                           </svg>
                           <!-- <span class="fas fa-edit"></span> Font Awesome fontawesome.com -->
                        </button>
                        <button class="btn btn-phoenix-secondary btn-icon fs-10 text-danger px-0" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                           </svg>
                           <!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com -->
                        </button>
                     </div>
                  </div>
               </div>
               <div class="d-flex hover-actions-trigger py-3 border-translucent border-top">
                  <input class="form-check-input form-check-input-todolist flex-shrink-0 my-1 me-2 form-check-input-undefined" type="checkbox" id="checkbox-todo-7" data-event-propagation-prevent="data-event-propagation-prevent">
                  <div class="row justify-content-between align-items-md-center btn-reveal-trigger border-translucent gx-0 flex-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#exampleModal">
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="mb-1 mb-md-0 d-flex align-items-center lh-1"><label class="form-check-label mb-1 mb-md-0 mb-xl-1 mb-xxl-0 fs-8 me-2 line-clamp-1 text-body cursor-pointer">warming up</label><span class="badge badge-phoenix ms-auto fs-10 badge-phoenix-secondary">CLOSE</span></div>
                     </div>
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="d-flex lh-1 align-items-center">
                           <a class="text-body-tertiary fw-bold fs-10 me-2" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                              <svg class="svg-inline--fa fa-paperclip me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="paperclip" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                 <path fill="currentColor" d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z"></path>
                              </svg>
                              <!-- <span class="fas fa-paperclip me-1"></span> Font Awesome fontawesome.com -->3
                           </a>
                           <p class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 me-xl-2 me-xxl-3 mb-0">12 Nov, 2021</p>
                           <div class="hover-md-hide hover-xl-show hover-xxl-hide">
                              <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0 ps-md-3 ps-xl-0 ps-xxl-3 border-start-md border-xl-0 border-start-xxl">12:00 PM</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="d-none d-md-block d-xl-none d-xxl-block end-0 position-absolute" style="top: 23%;" data-event-propagation-prevent="data-event-propagation-prevent">
                     <div class="hover-actions end-0" data-event-propagation-prevent="data-event-propagation-prevent">
                        <button class="btn btn-phoenix-secondary btn-icon me-1 fs-10 text-body px-0 me-1" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-pen-to-square" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen-to-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path>
                           </svg>
                           <!-- <span class="fas fa-edit"></span> Font Awesome fontawesome.com -->
                        </button>
                        <button class="btn btn-phoenix-secondary btn-icon fs-10 text-danger px-0" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                           </svg>
                           <!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com -->
                        </button>
                     </div>
                  </div>
               </div>
               <div class="d-flex hover-actions-trigger py-3 border-translucent border-top">
                  <input class="form-check-input form-check-input-todolist flex-shrink-0 my-1 me-2 form-check-input-undefined" type="checkbox" id="checkbox-todo-8" data-event-propagation-prevent="data-event-propagation-prevent">
                  <div class="row justify-content-between align-items-md-center btn-reveal-trigger border-translucent gx-0 flex-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#exampleModal">
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="mb-1 mb-md-0 d-flex align-items-center lh-1"><label class="form-check-label mb-1 mb-md-0 mb-xl-1 mb-xxl-0 fs-8 me-2 line-clamp-1 text-body cursor-pointer">Make ready for release</label></div>
                     </div>
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="d-flex lh-1 align-items-center">
                           <a class="text-body-tertiary fw-bold fs-10 me-2" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                              <svg class="svg-inline--fa fa-paperclip me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="paperclip" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                 <path fill="currentColor" d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z"></path>
                              </svg>
                              <!-- <span class="fas fa-paperclip me-1"></span> Font Awesome fontawesome.com -->2
                           </a>
                           <a class="text-warning fw-bold fs-10 me-2" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                              <svg class="svg-inline--fa fa-list-check me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="list-check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                 <path fill="currentColor" d="M152.1 38.2c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 113C-2.3 103.6-2.3 88.4 7 79s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zm0 160c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 273c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zM224 96c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zm0 160c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zM160 416c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H192c-17.7 0-32-14.3-32-32zM48 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"></path>
                              </svg>
                              <!-- <span class="fas fa-tasks me-1"></span> Font Awesome fontawesome.com -->2
                           </a>
                           <p class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 me-xl-2 me-xxl-3 mb-0">2o Nov, 2021</p>
                           <div class="hover-md-hide hover-xl-show hover-xxl-hide">
                              <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0 ps-md-3 ps-xl-0 ps-xxl-3 border-start-md border-xl-0 border-start-xxl">1:00 AM</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="d-none d-md-block d-xl-none d-xxl-block end-0 position-absolute" style="top: 23%;" data-event-propagation-prevent="data-event-propagation-prevent">
                     <div class="hover-actions end-0" data-event-propagation-prevent="data-event-propagation-prevent">
                        <button class="btn btn-phoenix-secondary btn-icon me-1 fs-10 text-body px-0 me-1" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-pen-to-square" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen-to-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path>
                           </svg>
                           <!-- <span class="fas fa-edit"></span> Font Awesome fontawesome.com -->
                        </button>
                        <button class="btn btn-phoenix-secondary btn-icon fs-10 text-danger px-0" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                           </svg>
                           <!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com -->
                        </button>
                     </div>
                  </div>
               </div>
               <div class="d-flex hover-actions-trigger py-3 border-translucent border-top">
                  <input class="form-check-input form-check-input-todolist flex-shrink-0 my-1 me-2 form-check-input-undefined" type="checkbox" id="checkbox-todo-9" data-event-propagation-prevent="data-event-propagation-prevent">
                  <div class="row justify-content-between align-items-md-center btn-reveal-trigger border-translucent gx-0 flex-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#exampleModal">
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="mb-1 mb-md-0 d-flex align-items-center lh-1"><label class="form-check-label mb-1 mb-md-0 mb-xl-1 mb-xxl-0 fs-8 me-2 line-clamp-1 text-body cursor-pointer">Modify the component</label></div>
                     </div>
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="d-flex lh-1 align-items-center">
                           <a class="text-body-tertiary fw-bold fs-10 me-2" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                              <svg class="svg-inline--fa fa-paperclip me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="paperclip" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                 <path fill="currentColor" d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z"></path>
                              </svg>
                              <!-- <span class="fas fa-paperclip me-1"></span> Font Awesome fontawesome.com -->4
                           </a>
                           <p class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 me-xl-2 me-xxl-3 mb-0">22 Nov, 2021</p>
                           <div class="hover-md-hide hover-xl-show hover-xxl-hide">
                              <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0 ps-md-3 ps-xl-0 ps-xxl-3 border-start-md border-xl-0 border-start-xxl">1:00 AM</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="d-none d-md-block d-xl-none d-xxl-block end-0 position-absolute" style="top: 23%;" data-event-propagation-prevent="data-event-propagation-prevent">
                     <div class="hover-actions end-0" data-event-propagation-prevent="data-event-propagation-prevent">
                        <button class="btn btn-phoenix-secondary btn-icon me-1 fs-10 text-body px-0 me-1" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-pen-to-square" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen-to-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path>
                           </svg>
                           <!-- <span class="fas fa-edit"></span> Font Awesome fontawesome.com -->
                        </button>
                        <button class="btn btn-phoenix-secondary btn-icon fs-10 text-danger px-0" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                           </svg>
                           <!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com -->
                        </button>
                     </div>
                  </div>
               </div>
               <div class="d-flex hover-actions-trigger py-3 border-translucent border-top border-bottom">
                  <input class="form-check-input form-check-input-todolist flex-shrink-0 my-1 me-2 form-check-input-undefined" type="checkbox" id="checkbox-todo-10" data-event-propagation-prevent="data-event-propagation-prevent">
                  <div class="row justify-content-between align-items-md-center btn-reveal-trigger border-translucent gx-0 flex-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#exampleModal">
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="mb-1 mb-md-0 d-flex align-items-center lh-1"><label class="form-check-label mb-1 mb-md-0 mb-xl-1 mb-xxl-0 fs-8 me-2 line-clamp-1 text-body cursor-pointer">Delete overlapping tasks and articles</label><span class="badge badge-phoenix ms-auto fs-10 badge-phoenix-secondary">CLOSE</span></div>
                     </div>
                     <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="d-flex lh-1 align-items-center">
                           <a class="text-body-tertiary fw-bold fs-10 me-2" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                              <svg class="svg-inline--fa fa-paperclip me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="paperclip" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                 <path fill="currentColor" d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z"></path>
                              </svg>
                              <!-- <span class="fas fa-paperclip me-1"></span> Font Awesome fontawesome.com -->2
                           </a>
                           <p class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 me-xl-2 me-xxl-3 mb-0">25 Nov, 2021</p>
                           <div class="hover-md-hide hover-xl-show hover-xxl-hide">
                              <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0 ps-md-3 ps-xl-0 ps-xxl-3 border-start-md border-xl-0 border-start-xxl">1:00 AM</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="d-none d-md-block d-xl-none d-xxl-block end-0 position-absolute" style="top: 23%;" data-event-propagation-prevent="data-event-propagation-prevent">
                     <div class="hover-actions end-0" data-event-propagation-prevent="data-event-propagation-prevent">
                        <button class="btn btn-phoenix-secondary btn-icon me-1 fs-10 text-body px-0 me-1" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-pen-to-square" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen-to-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path>
                           </svg>
                           <!-- <span class="fas fa-edit"></span> Font Awesome fontawesome.com -->
                        </button>
                        <button class="btn btn-phoenix-secondary btn-icon fs-10 text-danger px-0" data-event-propagation-prevent="data-event-propagation-prevent">
                           <svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                           </svg>
                           <!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com -->
                        </button>
                     </div>
                  </div>
               </div>
               <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-xl">
                     <div class="modal-content bg-body overflow-hidden">
                        <div class="modal-header justify-content-between px-6 py-5 pe-sm-5 px-md-6 dark__bg-gray-1100">
                           <h3 class="text-body-highlight fw-bolder mb-0">Designing the Dungeon Blueprint</h3>
                           <button class="btn btn-phoenix-secondary btn-icon btn-icon-xl flex-shrink-0" type="button" data-bs-dismiss="modal" aria-label="Close">
                              <svg class="svg-inline--fa fa-xmark" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                 <path fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path>
                              </svg>
                              <!-- <span class="fa-solid fa-xmark"></span> Font Awesome fontawesome.com -->
                           </button>
                        </div>
                        <div class="modal-body bg-body-highlight px-6 py-0">
                           <div class="row gx-14">
                              <div class="col-12 col-lg-7 border-end-lg">
                                 <div class="py-6">
                                    <div class="mb-7">
                                       <div class="d-flex align-items-center mb-3">
                                          <h4 class="text-body me-3">Description</h4>
                                          <a class="btn btn-link text-decoration-none p-0" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                             <svg class="svg-inline--fa fa-pen" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                <path fill="currentColor" d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"></path>
                                             </svg>
                                             <!-- <span class="fa-solid fa-pen"></span> Font Awesome fontawesome.com -->
                                          </a>
                                       </div>
                                       <p class="text-body-highlight mb-0">The female circus horse-rider is a recurring subject in Chagall’s work. In 1926 the art dealer Ambroise Vollard invited Chagall to make a project based on the circus. They visited Paris’s historic Cirque d’Hiver Bouglione together; Vollard lent Chagall his private box seats. Chagall completed 19 gouaches Chagall’s work. In 1926 the art dealer Ambroise Vollard invited Chagall to make a project based on the circus.</p>
                                    </div>
                                    <div class="mb-7">
                                       <h4 class="mb-3">Subtasks</h4>
                                       <div class="d-flex flex-between-center hover-actions-trigger py-3 border-top">
                                          <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1 min-h-auto"><input class="subtask-checkbox form-check-input form-check-line-through mt-0 me-3" type="checkbox" id="subtaskundefined1"><label class="form-check-label mb-0 fs-8" for="subtaskundefined1">Study Dragons</label></div>
                                          <div class="hover-actions end-0">
                                             <button class="btn btn-sm me-1 fs-10 text-body-tertiary px-0 me-3">
                                                <svg class="svg-inline--fa fa-pencil" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pencil" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-pencil"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn btn-sm text-body-tertiary px-0">
                                                <svg class="svg-inline--fa fa-xmark fs-8" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-xmark fs-8"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                       </div>
                                       <div class="d-flex flex-between-center hover-actions-trigger py-3 border-top">
                                          <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1 min-h-auto"><input class="subtask-checkbox form-check-input form-check-line-through mt-0 me-3" type="checkbox" id="subtaskundefined2"><label class="form-check-label mb-0 fs-8" for="subtaskundefined2">Procrastinate a bit</label></div>
                                          <div class="hover-actions end-0">
                                             <button class="btn btn-sm me-1 fs-10 text-body-tertiary px-0 me-3">
                                                <svg class="svg-inline--fa fa-pencil" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pencil" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-pencil"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn btn-sm text-body-tertiary px-0">
                                                <svg class="svg-inline--fa fa-xmark fs-8" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-xmark fs-8"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                       </div>
                                       <div class="d-flex flex-between-center hover-actions-trigger py-3 border-top border-bottom mb-3">
                                          <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1 min-h-auto"><input class="subtask-checkbox form-check-input form-check-line-through mt-0 me-3" type="checkbox" id="subtaskundefined3"><label class="form-check-label mb-0 fs-8" for="subtaskundefined3">Staring at the notebook for 5 mins</label></div>
                                          <div class="hover-actions end-0">
                                             <button class="btn btn-sm me-1 fs-10 text-body-tertiary px-0 me-3">
                                                <svg class="svg-inline--fa fa-pencil" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pencil" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-pencil"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn btn-sm text-body-tertiary px-0">
                                                <svg class="svg-inline--fa fa-xmark fs-8" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-xmark fs-8"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                       </div>
                                       <a class="fw-bold fs-9" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                          <svg class="svg-inline--fa fa-plus me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                             <path fill="currentColor" d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"></path>
                                          </svg>
                                          <!-- <span class="fas fa-plus me-1"></span> Font Awesome fontawesome.com -->Add subtask
                                       </a>
                                    </div>
                                    <div class="mb-3">
                                       <div>
                                          <h4 class="mb-3">Files</h4>
                                       </div>
                                       <div class="border-top px-0 pt-4 pb-3">
                                          <div class="me-n3">
                                             <div class="d-flex flex-between-center">
                                                <div class="d-flex mb-1">
                                                   <svg class="svg-inline--fa fa-image me-2 text-body-tertiary fs-9" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="image" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 96C0 60.7 28.7 32 64 32H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zM323.8 202.5c-4.5-6.6-11.9-10.5-19.8-10.5s-15.4 3.9-19.8 10.5l-87 127.6L170.7 297c-4.6-5.7-11.5-9-18.7-9s-14.2 3.3-18.7 9l-64 80c-5.8 7.2-6.9 17.1-2.9 25.4s12.4 13.6 21.6 13.6h96 32H424c8.9 0 17.1-4.9 21.2-12.8s3.6-17.4-1.4-24.7l-120-176zM112 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-image me-2 text-body-tertiary fs-9"></span> Font Awesome fontawesome.com -->
                                                   <p class="text-body-highlight mb-0 lh-1">Silly_sight_1.png</p>
                                                </div>
                                                <div class="btn-reveal-trigger">
                                                   <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                      <svg class="svg-inline--fa fa-ellipsis" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                         <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                      </svg>
                                                      <!-- <span class="fas fa-ellipsis-h"></span> Font Awesome fontawesome.com -->
                                                   </button>
                                                   <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Edit</a><a class="dropdown-item text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Delete</a><a class="dropdown-item" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Download</a><a class="dropdown-item" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Report abuse</a></div>
                                                </div>
                                             </div>
                                             <div class="d-flex fs-9 text-body-tertiary mb-2 flex-wrap"><span>768 kb</span><span class="text-body-quaternary mx-1">| </span><a href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Shantinan Mekalan </a><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap">21st Dec, 12:56 PM</span></div>
                                             <img class="rounded-2" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/40.png" alt="" style="width:230px">
                                          </div>
                                       </div>
                                       <div class="border-top px-0 pt-4 pb-3">
                                          <div class="me-n3">
                                             <div class="d-flex flex-between-center">
                                                <div>
                                                   <div class="d-flex align-items-center mb-1">
                                                      <svg class="svg-inline--fa fa-image me-2 fs-9 text-body-tertiary" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="image" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                         <path fill="currentColor" d="M0 96C0 60.7 28.7 32 64 32H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zM323.8 202.5c-4.5-6.6-11.9-10.5-19.8-10.5s-15.4 3.9-19.8 10.5l-87 127.6L170.7 297c-4.6-5.7-11.5-9-18.7-9s-14.2 3.3-18.7 9l-64 80c-5.8 7.2-6.9 17.1-2.9 25.4s12.4 13.6 21.6 13.6h96 32H424c8.9 0 17.1-4.9 21.2-12.8s3.6-17.4-1.4-24.7l-120-176zM112 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"></path>
                                                      </svg>
                                                      <!-- <span class="fa-solid fa-image me-2 fs-9 text-body-tertiary"></span> Font Awesome fontawesome.com -->
                                                      <p class="text-body-highlight mb-0 lh-1">All_images.zip</p>
                                                   </div>
                                                   <div class="d-flex fs-9 text-body-tertiary mb-0 flex-wrap"><span>12.8 mb</span><span class="text-body-quaternary mx-1">| </span><a href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Yves Tanguy </a><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap">19th Dec, 08:56 PM</span></div>
                                                </div>
                                                <div class="btn-reveal-trigger">
                                                   <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                      <svg class="svg-inline--fa fa-ellipsis" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                         <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                      </svg>
                                                      <!-- <span class="fas fa-ellipsis-h"></span> Font Awesome fontawesome.com -->
                                                   </button>
                                                   <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Edit</a><a class="dropdown-item text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Delete</a><a class="dropdown-item" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Download</a><a class="dropdown-item" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Report abuse</a></div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="border-top px-0 pt-4 pb-3 border-bottom">
                                          <div class="me-n3">
                                             <div class="d-flex flex-between-center">
                                                <div>
                                                   <div class="d-flex align-items-center mb-1 flex-wrap">
                                                      <svg class="svg-inline--fa fa-file-lines me-2 fs-9 text-body-tertiary" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="file-lines" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                         <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM112 256H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16z"></path>
                                                      </svg>
                                                      <!-- <span class="fa-solid fa-file-lines me-2 fs-9 text-body-tertiary"></span> Font Awesome fontawesome.com -->
                                                      <p class="text-body-highlight mb-0 lh-1">Project.txt</p>
                                                   </div>
                                                   <div class="d-flex fs-9 text-body-tertiary mb-0 flex-wrap"><span>123 kb</span><span class="text-body-quaternary mx-1">| </span><a href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Shantinan Mekalan </a><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap">12th Dec, 12:56 PM</span></div>
                                                </div>
                                                <div class="btn-reveal-trigger">
                                                   <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                      <svg class="svg-inline--fa fa-ellipsis" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                         <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                      </svg>
                                                      <!-- <span class="fas fa-ellipsis-h"></span> Font Awesome fontawesome.com -->
                                                   </button>
                                                   <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Edit</a><a class="dropdown-item text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Delete</a><a class="dropdown-item" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Download</a><a class="dropdown-item" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Report abuse</a></div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="mt-3">
                                          <label class="btn btn-link p-0" for="customFile">
                                             <svg class="svg-inline--fa fa-plus me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                <path fill="currentColor" d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"></path>
                                             </svg>
                                             <!-- <span class="fas fa-plus me-1"></span> Font Awesome fontawesome.com -->Add file(s)
                                          </label>
                                          <input class="d-none" id="customFile" type="file">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-12 col-lg-5">
                                 <div class="py-6">
                                    <h4 class="mb-4 text-body-emphasis">Others Information</h4>
                                    <h5 class="text-body-highlight mb-2">Status</h5>
                                    <select class="form-select mb-4" aria-label="Default select example">
                                       <option selected="">Select</option>
                                       <option value="1">One</option>
                                       <option value="2">Two</option>
                                       <option value="3">Three</option>
                                    </select>
                                    <h5 class="text-body-highlight mb-2">Due Date</h5>
                                    <div class="flatpickr-input-container mb-4"><input class="form-control datetimepicker ps-6 flatpickr-input" type="text" placeholder="Set the due date" data-options="{&quot;disableMobile&quot;:true}" readonly="readonly"><span class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span></div>
                                    <h5 class="text-body-highlight mb-2">Reminder</h5>
                                    <div class="flatpickr-input-container mb-4">
                                       <div class="flatpickr-wrapper">
                                          <div class="flatpickr-wrapper">
                                             <input class="form-control datetimepicker ps-6 flatpickr-input" type="text" placeholder="Reminder" data-options="{&quot;enableTime&quot;:true,&quot;noCalendar&quot;:true,&quot;dateFormat&quot;:&quot;H:i&quot;,&quot;disableMobile&quot;:true,&quot;static&quot;:true}" readonly="readonly">
                                             <div class="flatpickr-calendar hasTime noCalendar animate static" tabindex="-1">
                                                <div class="flatpickr-time" tabindex="-1">
                                                   <div class="numInputWrapper"><input class="numInput flatpickr-hour" type="number" aria-label="Hour" tabindex="-1" step="1" min="1" max="12" maxlength="2"><span class="arrowUp"></span><span class="arrowDown"></span></div>
                                                   <span class="flatpickr-time-separator">:</span>
                                                   <div class="numInputWrapper"><input class="numInput flatpickr-minute" type="number" aria-label="Minute" tabindex="-1" step="5" min="0" max="59" maxlength="2"><span class="arrowUp"></span><span class="arrowDown"></span></div>
                                                   <span class="flatpickr-am-pm" title="Click to toggle" tabindex="-1">PM</span>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="flatpickr-calendar hasTime noCalendar animate static" tabindex="-1">
                                             <div class="flatpickr-time" tabindex="-1">
                                                <div class="numInputWrapper"><input class="numInput flatpickr-hour" type="number" aria-label="Hour" tabindex="-1" step="1" min="1" max="12" maxlength="2"><span class="arrowUp"></span><span class="arrowDown"></span></div>
                                                <span class="flatpickr-time-separator">:</span>
                                                <div class="numInputWrapper"><input class="numInput flatpickr-minute" type="number" aria-label="Minute" tabindex="-1" step="5" min="0" max="59" maxlength="2"><span class="arrowUp"></span><span class="arrowDown"></span></div>
                                                <span class="flatpickr-am-pm" title="Click to toggle" tabindex="-1">PM</span>
                                             </div>
                                          </div>
                                       </div>
                                       <span class="uil uil-bell-school flatpickr-icon text-body-tertiary"></span>
                                    </div>
                                    <h5 class="text-body-highlight mb-2">Tag</h5>
                                    <div class="choices-select-container mb-6">
                                       <div class="choices" data-type="select-multiple" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false">
                                          <div class="choices__inner">
                                             <select class="form-select choices__input" data-choices="data-choices" multiple="multiple" data-options="{&quot;removeItemButton&quot;:true,&quot;placeholder&quot;:true}" hidden="" tabindex="-1" data-choice="active"></select>
                                             <div class="choices__list choices__list--multiple"></div>
                                             <input type="search" name="search_terms" class="choices__input choices__input--cloned" autocomplete="off" autocapitalize="off" spellcheck="false" role="textbox" aria-autocomplete="list" aria-label="Select organizer..." placeholder="Select organizer..." style="min-width: 20ch; width: 1ch;">
                                          </div>
                                          <div class="choices__list choices__list--dropdown" aria-expanded="false">
                                             <div class="choices__list" aria-multiselectable="true" role="listbox">
                                                <div id="choices--t7ec-item-choice-1" class="choices__item choices__item--choice choices__item--selectable is-highlighted" role="option" data-choice="" data-id="1" data-value="California Institute of Technology" data-select-text="" data-choice-selectable="" aria-selected="true">California Institute of Technology</div>
                                                <div id="choices--t7ec-item-choice-2" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="2" data-value="GSAS Open Labs At Harvard" data-select-text="" data-choice-selectable="">GSAS Open Labs At Harvard</div>
                                                <div id="choices--t7ec-item-choice-3" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="3" data-value="Massachusetts Institute of Technology" data-select-text="" data-choice-selectable="">Massachusetts Institute of Technology</div>
                                                <div id="choices--t7ec-item-choice-5" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="5" data-value="University of Chicago" data-select-text="" data-choice-selectable="">University of Chicago</div>
                                             </div>
                                          </div>
                                       </div>
                                       <span class="uil uil-tag-alt choices-icon text-body-tertiary" style="top: 26%;"></span>
                                    </div>
                                    <div class="text-end mb-9"><button class="btn btn-phoenix-danger">Delete Task</button></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="card-footer border-0">
               <a class="fw-bold fs-9 mt-4" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                  <svg class="svg-inline--fa fa-plus me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                     <path fill="currentColor" d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"></path>
                  </svg>
                  <!-- <span class="fas fa-plus me-1"></span> Font Awesome fontawesome.com -->Add new task
               </a>
            </div>
         </div>
      </div>
      <div class="col-12 col-xl-6 col-xxl-5">
         <div class="card h-100 ydcoza-timeline-vertical">
            <div class="card-body">
               <div class="card-title mb-1">
                  <h3 class="text-body-emphasis">Development</h3>
               </div>
               <p class="text-body-tertiary mb-4">Recent development activity across all plugins.</p>
               <div class="timeline-scroll-wrapper" style="max-height: 600px; overflow-y: auto; overflow-x: hidden; padding-right: 10px;">
               <div class="timeline-vertical timeline-with-details">


               <!-- Generated timeline items -->
               <?php 
               // Load the JSON data
               $json_file = get_stylesheet_directory() . '/dashboard-timeline-data.json';
               $timeline_data = [];
               
               if (file_exists($json_file)) {
                   $json_content = file_get_contents($json_file);
                   $timeline_data = json_decode($json_content, true);
               }
               
               // Define a set of icons to rotate through
               $icons = [
                   'fa-dove',
                   'fa-chess',
                   'fa-rocket',
                   'fa-star',
                   'fa-bolt',
                   'fa-fire',
                   'fa-heart',
                   'fa-trophy',
                   'fa-gem',
                   'fa-crown'
               ];
               
               // Generate timeline items
               if (!empty($timeline_data)) {
                   foreach ($timeline_data as $index => $item) {
                       // Get a random icon or cycle through them
                       $icon = $icons[$index % count($icons)];
                       
                       // Truncate title for display
                       $display_title = strlen($item['Title']) > 120 ? substr($item['Title'], 0, 120) . '...' : $item['Title'];
                       
                       // Extract first part of description for preview
                       $preview_desc = strlen($item['Description']) > 280 ? substr($item['Description'], 0, 280) . '...' : $item['Description'];
               ?>
                  <div class="timeline-item position-relative">
                     <div class="row g-md-3">
                        <div class="col-12 col-md-auto d-flex">
                           <div class="timeline-item-date order-1 order-md-0 me-md-4">
                              <p class="fs-10 fw-semibold text-body-tertiary text-opacity-85 text-end"><?php echo esc_html($item['Date']); ?><br class="d-none d-md-block"> <?php echo esc_html($item['Time']); ?></p>
                           </div>
                           <div class="timeline-item-bar position-md-relative me-3 me-md-0">
                              <div class="icon-item icon-item-sm rounded-7 shadow-none bg-primary-subtle">
                                 <span class="fa-solid <?php echo esc_attr($icon); ?> text-primary-dark fs-10"></span>
                              </div>
                              <span class="timeline-bar border-end border-dashed"></span>
                           </div>
                        </div>
                        <div class="col">
                           <div class="timeline-item-content ps-6 ps-md-3">
                              <h5 class="fs-9 lh-sm"><?php echo esc_html($display_title); ?></h5>
                              <p class="fs-9">by <a class="fw-semibold" href="#">John @ YourDesign.co.za</a></p>
                              <p class="fs-9 text-body-secondary mb-5"><?php echo esc_html($preview_desc); ?></p>
                           </div>
                        </div>
                     </div>
                  </div>
               <?php 
                   }
               } else {
                   // Fallback if no data is available
               ?>
                  <div class="timeline-item position-relative">
                     <div class="row g-md-3">
                        <div class="col">
                           <div class="timeline-item-content ps-6 ps-md-3">
                              <p class="fs-9 text-body-secondary mb-5">No timeline data available.</p>
                           </div>
                        </div>
                     </div>
                  </div>
               <?php 
               }
               ?>
               <!-- END Generated timeline items -->



               </div>
               </div>
            </div>
         </div>
      </div>
   </div>

<?php echo do_shortcode('[wecoza_event_tasks]'); ?>

   <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis pt-7 mt-5 border-y">
      <div data-list="{&quot;valueNames&quot;:[&quot;product&quot;,&quot;customer&quot;,&quot;rating&quot;,&quot;review&quot;,&quot;time&quot;],&quot;page&quot;:6}">
         <div class="row align-items-end justify-content-between pb-5 g-3">
            <div class="col-auto">
               <h3>Latest reviews</h3>
               <p class="text-body-tertiary lh-sm mb-0">Payment received across all channels</p>
            </div>
            <div class="col-12 col-md-auto">
               <div class="row g-2 gy-3">
                  <div class="col-auto flex-1">
                     <div class="search-box">
                        <form class="position-relative">
                           <input class="form-control search-input search form-control-sm" type="search" placeholder="Search" aria-label="Search">
                           <svg class="svg-inline--fa fa-magnifying-glass search-box-icon" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="magnifying-glass" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path>
                           </svg>
                           <!-- <span class="fas fa-search search-box-icon"></span> Font Awesome fontawesome.com -->
                        </form>
                     </div>
                  </div>
                  <div class="col-auto">
                     <button class="btn btn-sm btn-phoenix-secondary bg-body-emphasis bg-body-hover me-2" type="button">All products</button>
                     <button class="btn btn-sm btn-phoenix-secondary bg-body-emphasis bg-body-hover action-btn" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                        <svg class="svg-inline--fa fa-ellipsis" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="" style="transform-origin: 0.4375em 0.5em;">
                           <g transform="translate(224 256)">
                              <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                 <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z" transform="translate(-224 -256)"></path>
                              </g>
                           </g>
                        </svg>
                        <!-- <span class="fas fa-ellipsis-h" data-fa-transform="shrink-2"></span> Font Awesome fontawesome.com -->
                     </button>
                     <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="table-responsive mx-n1 px-1 scrollbar">
            <table class="table fs-9 mb-0 border-top border-translucent">
               <thead>
                  <tr>
                     <th class="white-space-nowrap fs-9 ps-0 align-middle">
                        <div class="form-check mb-0 fs-8"><input class="form-check-input" id="checkbox-bulk-reviews-select" type="checkbox" data-bulk-select="{&quot;body&quot;:&quot;table-latest-review-body&quot;}"></div>
                     </th>
                     <th class="sort white-space-nowrap align-middle" scope="col"></th>
                     <th class="sort white-space-nowrap align-middle" scope="col" style="min-width:360px;" data-sort="product">PRODUCT</th>
                     <th class="sort align-middle" scope="col" data-sort="customer" style="min-width:200px;">CUSTOMER</th>
                     <th class="sort align-middle" scope="col" data-sort="rating" style="min-width:110px;">RATING</th>
                     <th class="sort align-middle" scope="col" style="max-width:350px;" data-sort="review">REVIEW</th>
                     <th class="sort text-start ps-5 align-middle" scope="col" data-sort="status">STATUS</th>
                     <th class="sort text-end align-middle" scope="col" data-sort="time">TIME</th>
                     <th class="sort text-end pe-0 align-middle" scope="col"></th>
                  </tr>
               </thead>
               <tbody class="list" id="table-latest-review-body">
                  <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                     <td class="fs-9 align-middle ps-0">
                        <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox" data-bulk-select-row="{&quot;product&quot;:&quot;Fitbit Sense Advanced Smartwatch with Tools for Heart Health, Stress Management &amp; Skin Temperature Trends, Carbon/Graphite, One Size (S &amp; L Bands)&quot;,&quot;productImage&quot;&quot;,&quot;customer&quot;:{&quot;name&quot;:&quot;Richard Dawkins&quot;,&quot;avatar&quot;:&quot;&quot;},&quot;rating&quot;:5,&quot;review&quot;:&quot;This Fitbit is fantastic! I was trying to be in better shape and needed some motivation, so I decided to treat myself to a new Fitbit.&quot;,&quot;status&quot;:{&quot;title&quot;:&quot;Approved&quot;,&quot;badge&quot;:&quot;success&quot;,&quot;icon&quot;:&quot;check&quot;},&quot;time&quot;:&quot;Just now&quot;}"></div>
                     </td>
                     <td class="align-middle product white-space-nowrap py-0"><a class="d-block rounded-2 border border-translucent" href="apps/e-commerce/landing/product-details.html"><img src="https://prium.github.io/phoenix/v1.22.0/assets/img/products/60x60/1.png" alt="" width="53"></a></td>
                     <td class="align-middle product white-space-nowrap"><a class="fw-semibold" href="apps/e-commerce/landing/product-details.html">Fitbit Sense Advanced Smartwatch with Tools fo...</a></td>
                     <td class="align-middle customer white-space-nowrap">
                        <a class="d-flex align-items-center text-body" href="apps/e-commerce/landing/profile.html">
                           <div class="avatar avatar-l">
                              <div class="avatar-name rounded-circle"><span>R</span></div>
                           </div>
                           <h6 class="mb-0 ms-3 text-body">Richard Dawkins</h6>
                        </a>
                     </td>
                     <td class="align-middle rating white-space-nowrap fs-10">
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                     </td>
                     <td class="align-middle review" style="min-width:350px;">
                        <p class="fs-9 fw-semibold text-body-highlight mb-0">This Fitbit is fantastic! I was trying to be in better shape and needed some motivation, so I decided to treat myself to a new Fitbit.</p>
                     </td>
                     <td class="align-middle text-start ps-5 status">
                        <span class="badge badge-phoenix fs-10 badge-phoenix-success">
                           <span class="badge-label">Approved</span>
                           <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check ms-1" style="height:12.8px;width:12.8px;">
                              <polyline points="20 6 9 17 4 12"></polyline>
                           </svg>
                        </span>
                     </td>
                     <td class="align-middle text-end time white-space-nowrap">
                        <div class="hover-hide">
                           <h6 class="text-body-highlight mb-0">Just now</h6>
                        </div>
                     </td>
                     <td class="align-middle white-space-nowrap text-end pe-0">
                        <div class="position-relative">
                           <div class="hover-actions">
                              <button class="btn btn-sm btn-phoenix-secondary me-1 fs-10">
                                 <svg class="svg-inline--fa fa-check" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"></path>
                                 </svg>
                                 <!-- <span class="fas fa-check"></span> Font Awesome fontawesome.com -->
                              </button>
                              <button class="btn btn-sm btn-phoenix-secondary fs-10">
                                 <svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                                 </svg>
                                 <!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com -->
                              </button>
                           </div>
                        </div>
                        <div class="btn-reveal-trigger position-static">
                           <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                              <svg class="svg-inline--fa fa-ellipsis fs-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                 <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                              </svg>
                              <!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com -->
                           </button>
                           <div class="dropdown-menu dropdown-menu-end py-2">
                              <a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item text-danger" href="#!">Remove</a>
                           </div>
                        </div>
                     </td>
                  </tr>
                  <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                     <td class="fs-9 align-middle ps-0">
                        <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox" data-bulk-select-row="{&quot;product&quot;:&quot;iPhone 13 pro max-Pacific Blue-128GB storage&quot;,&quot;productImage&quot;:&quot;/products/60x60/2.png&quot;,&quot;customer&quot;:{&quot;name&quot;:&quot;Ashley Garrett&quot;,&quot;avatar&quot;:&quot;/team/40x40/59.webp&quot;},&quot;rating&quot;:3,&quot;review&quot;:&quot;The order was delivered ahead of schedule. To give us additional time, you should leave the packaging sealed with plastic.&quot;,&quot;status&quot;:{&quot;title&quot;:&quot;Approved&quot;,&quot;badge&quot;:&quot;success&quot;,&quot;icon&quot;:&quot;check&quot;},&quot;time&quot;:&quot;Just now&quot;}"></div>
                     </td>
                     <td class="align-middle product white-space-nowrap py-0"><a class="d-block rounded-2 border border-translucent" href="apps/e-commerce/landing/product-details.html"><img src="https://prium.github.io/phoenix/v1.22.0/assets/img/products/60x60/2.png" alt="" width="53"></a></td>
                     <td class="align-middle product white-space-nowrap"><a class="fw-semibold" href="apps/e-commerce/landing/product-details.html">iPhone 13 pro max-Pacific Blue-128GB storage</a></td>
                     <td class="align-middle customer white-space-nowrap">
                        <a class="d-flex align-items-center text-body" href="apps/e-commerce/landing/profile.html">
                           <div class="avatar avatar-l"><img class="rounded-circle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/40x40/59.webp" alt=""></div>
                           <h6 class="mb-0 ms-3 text-body">Ashley Garrett</h6>
                        </a>
                     </td>
                     <td class="align-middle rating white-space-nowrap fs-10">
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning-light" data-bs-theme="light" aria-hidden="true" focusable="false" data-prefix="far" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z"></path>
                        </svg>
                        <!-- <span class="fa-regular fa-star text-warning-light" data-bs-theme="light"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning-light" data-bs-theme="light" aria-hidden="true" focusable="false" data-prefix="far" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z"></path>
                        </svg>
                        <!-- <span class="fa-regular fa-star text-warning-light" data-bs-theme="light"></span> Font Awesome fontawesome.com -->
                     </td>
                     <td class="align-middle review" style="min-width:350px;">
                        <p class="fs-9 fw-semibold text-body-highlight mb-0">The order was delivered ahead of schedule. To give us additional time, you should leave the packaging sealed with plastic.</p>
                     </td>
                     <td class="align-middle text-start ps-5 status">
                        <span class="badge badge-phoenix fs-10 badge-phoenix-success">
                           <span class="badge-label">Approved</span>
                           <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check ms-1" style="height:12.8px;width:12.8px;">
                              <polyline points="20 6 9 17 4 12"></polyline>
                           </svg>
                        </span>
                     </td>
                     <td class="align-middle text-end time white-space-nowrap">
                        <div class="hover-hide">
                           <h6 class="text-body-highlight mb-0">Just now</h6>
                        </div>
                     </td>
                     <td class="align-middle white-space-nowrap text-end pe-0">
                        <div class="position-relative">
                           <div class="hover-actions">
                              <button class="btn btn-sm btn-phoenix-secondary me-1 fs-10">
                                 <svg class="svg-inline--fa fa-check" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"></path>
                                 </svg>
                                 <!-- <span class="fas fa-check"></span> Font Awesome fontawesome.com -->
                              </button>
                              <button class="btn btn-sm btn-phoenix-secondary fs-10">
                                 <svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                                 </svg>
                                 <!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com -->
                              </button>
                           </div>
                        </div>
                        <div class="btn-reveal-trigger position-static">
                           <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                              <svg class="svg-inline--fa fa-ellipsis fs-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                 <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                              </svg>
                              <!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com -->
                           </button>
                           <div class="dropdown-menu dropdown-menu-end py-2">
                              <a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item text-danger" href="#!">Remove</a>
                           </div>
                        </div>
                     </td>
                  </tr>
                  <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                     <td class="fs-9 align-middle ps-0">
                        <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox" data-bulk-select-row="{&quot;product&quot;:&quot;Apple MacBook Pro 13 inch-M1-8/256GB-space&quot;,&quot;productImage&quot;:&quot;/products/60x60/3.png&quot;,&quot;customer&quot;:{&quot;name&quot;:&quot;Woodrow Burton&quot;,&quot;avatar&quot;:&quot;/team/40x40/58.webp&quot;},&quot;rating&quot;:4.5,&quot;review&quot;:&quot;It's a Mac, after all. Once you've gone Mac, there's no going back. My first Mac lasted over nine years, and this is my second.&quot;,&quot;status&quot;:{&quot;title&quot;:&quot;Pending&quot;,&quot;badge&quot;:&quot;warning&quot;,&quot;icon&quot;:&quot;clock&quot;},&quot;time&quot;:&quot;Just now&quot;}"></div>
                     </td>
                     <td class="align-middle product white-space-nowrap py-0"><a class="d-block rounded-2 border border-translucent" href="apps/e-commerce/landing/product-details.html"><img src="https://prium.github.io/phoenix/v1.22.0/assets/img/products/60x60/3.png" alt="" width="53"></a></td>
                     <td class="align-middle product white-space-nowrap"><a class="fw-semibold" href="apps/e-commerce/landing/product-details.html">Apple MacBook Pro 13 inch-M1-8/256GB-space</a></td>
                     <td class="align-middle customer white-space-nowrap">
                        <a class="d-flex align-items-center text-body" href="apps/e-commerce/landing/profile.html">
                           <div class="avatar avatar-l"><img class="rounded-circle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/40x40/58.webp" alt=""></div>
                           <h6 class="mb-0 ms-3 text-body">Woodrow Burton</h6>
                        </a>
                     </td>
                     <td class="align-middle rating white-space-nowrap fs-10">
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star-half-stroke star-icon text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star-half-stroke" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M288 376.4l.1-.1 26.4 14.1 85.2 45.5-16.5-97.6-4.8-28.7 20.7-20.5 70.1-69.3-96.1-14.2-29.3-4.3-12.9-26.6L288.1 86.9l-.1 .3V376.4zm175.1 98.3c2 12-3 24.2-12.9 31.3s-23 8-33.8 2.3L288.1 439.8 159.8 508.3C149 514 135.9 513.1 126 506s-14.9-19.3-12.9-31.3L137.8 329 33.6 225.9c-8.6-8.5-11.7-21.2-7.9-32.7s13.7-19.9 25.7-21.7L195 150.3 259.4 18c5.4-11 16.5-18 28.8-18s23.4 7 28.8 18l64.3 132.3 143.6 21.2c12 1.8 22 10.2 25.7 21.7s.7 24.2-7.9 32.7L438.5 329l24.6 145.7z"></path>
                        </svg>
                        <!-- <span class="fa fa-star-half-alt star-icon text-warning"></span> Font Awesome fontawesome.com -->
                     </td>
                     <td class="align-middle review" style="min-width:350px;">
                        <p class="fs-9 fw-semibold text-body-highlight mb-0">It's a Mac, after all. Once you've gone Mac, there's no going back. My first Mac lasted over nine years, and this is my second.</p>
                     </td>
                     <td class="align-middle text-start ps-5 status">
                        <span class="badge badge-phoenix fs-10 badge-phoenix-warning">
                           <span class="badge-label">Pending</span>
                           <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock ms-1" style="height:12.8px;width:12.8px;">
                              <circle cx="12" cy="12" r="10"></circle>
                              <polyline points="12 6 12 12 16 14"></polyline>
                           </svg>
                        </span>
                     </td>
                     <td class="align-middle text-end time white-space-nowrap">
                        <div class="hover-hide">
                           <h6 class="text-body-highlight mb-0">Just now</h6>
                        </div>
                     </td>
                     <td class="align-middle white-space-nowrap text-end pe-0">
                        <div class="position-relative">
                           <div class="hover-actions">
                              <button class="btn btn-sm btn-phoenix-secondary me-1 fs-10">
                                 <svg class="svg-inline--fa fa-check" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"></path>
                                 </svg>
                                 <!-- <span class="fas fa-check"></span> Font Awesome fontawesome.com -->
                              </button>
                              <button class="btn btn-sm btn-phoenix-secondary fs-10">
                                 <svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                                 </svg>
                                 <!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com -->
                              </button>
                           </div>
                        </div>
                        <div class="btn-reveal-trigger position-static">
                           <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                              <svg class="svg-inline--fa fa-ellipsis fs-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                 <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                              </svg>
                              <!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com -->
                           </button>
                           <div class="dropdown-menu dropdown-menu-end py-2">
                              <a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item text-danger" href="#!">Remove</a>
                           </div>
                        </div>
                     </td>
                  </tr>
                  <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                     <td class="fs-9 align-middle ps-0">
                        <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox" data-bulk-select-row="{&quot;product&quot;:&quot;Apple iMac 24\&quot; 4K Retina Display M1 8 Core CPU, 7 Core GPU, 256GB SSD, Green (MJV83ZP/A) 2021&quot;,&quot;productImage&quot;:&quot;/products/60x60/4.png&quot;,&quot;customer&quot;:{&quot;name&quot;:&quot;Eric McGee&quot;,&quot;avatar&quot;:&quot;/team/40x40/avatar.webp&quot;,&quot;avatarPlaceholder&quot;:true},&quot;rating&quot;:3,&quot;review&quot;:&quot;Personally, I like the minimalist style, but I wouldn't choose it if I were searching for a computer that I would use frequently. It's not horrible in terms of speed and power, but the&quot;,&quot;status&quot;:{&quot;title&quot;:&quot;Pending&quot;,&quot;badge&quot;:&quot;warning&quot;,&quot;icon&quot;:&quot;clock&quot;},&quot;time&quot;:&quot;Nov 09, 3:23 AM&quot;}"></div>
                     </td>
                     <td class="align-middle product white-space-nowrap py-0"><a class="d-block rounded-2 border border-translucent" href="apps/e-commerce/landing/product-details.html"><img src="https://prium.github.io/phoenix/v1.22.0/assets/img/products/60x60/4.png" alt="" width="53"></a></td>
                     <td class="align-middle product white-space-nowrap"><a class="fw-semibold" href="apps/e-commerce/landing/product-details.html">Apple iMac 24" 4K Retina Display M1 8 Core CPU...</a></td>
                     <td class="align-middle customer white-space-nowrap">
                        <a class="d-flex align-items-center text-body" href="apps/e-commerce/landing/profile.html">
                           <div class="avatar avatar-l"><img class="rounded-circle avatar-placeholder" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/40x40/avatar.webp" alt=""></div>
                           <h6 class="mb-0 ms-3 text-body">Eric McGee</h6>
                        </a>
                     </td>
                     <td class="align-middle rating white-space-nowrap fs-10">
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning-light" data-bs-theme="light" aria-hidden="true" focusable="false" data-prefix="far" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z"></path>
                        </svg>
                        <!-- <span class="fa-regular fa-star text-warning-light" data-bs-theme="light"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning-light" data-bs-theme="light" aria-hidden="true" focusable="false" data-prefix="far" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z"></path>
                        </svg>
                        <!-- <span class="fa-regular fa-star text-warning-light" data-bs-theme="light"></span> Font Awesome fontawesome.com -->
                     </td>
                     <td class="align-middle review" style="min-width:350px;">
                        <p class="fs-9 fw-semibold text-body-highlight mb-0">Personally, I like the minimalist style, but I wouldn't choose it if I were searching for a computer that I would use frequently. It's...<a href="#!">See more</a></p>
                     </td>
                     <td class="align-middle text-start ps-5 status">
                        <span class="badge badge-phoenix fs-10 badge-phoenix-warning">
                           <span class="badge-label">Pending</span>
                           <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock ms-1" style="height:12.8px;width:12.8px;">
                              <circle cx="12" cy="12" r="10"></circle>
                              <polyline points="12 6 12 12 16 14"></polyline>
                           </svg>
                        </span>
                     </td>
                     <td class="align-middle text-end time white-space-nowrap">
                        <div class="hover-hide">
                           <h6 class="text-body-highlight mb-0">Nov 09, 3:23 AM</h6>
                        </div>
                     </td>
                     <td class="align-middle white-space-nowrap text-end pe-0">
                        <div class="position-relative">
                           <div class="hover-actions">
                              <button class="btn btn-sm btn-phoenix-secondary me-1 fs-10">
                                 <svg class="svg-inline--fa fa-check" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"></path>
                                 </svg>
                                 <!-- <span class="fas fa-check"></span> Font Awesome fontawesome.com -->
                              </button>
                              <button class="btn btn-sm btn-phoenix-secondary fs-10">
                                 <svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                                 </svg>
                                 <!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com -->
                              </button>
                           </div>
                        </div>
                        <div class="btn-reveal-trigger position-static">
                           <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                              <svg class="svg-inline--fa fa-ellipsis fs-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                 <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                              </svg>
                              <!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com -->
                           </button>
                           <div class="dropdown-menu dropdown-menu-end py-2">
                              <a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item text-danger" href="#!">Remove</a>
                           </div>
                        </div>
                     </td>
                  </tr>
                  <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                     <td class="fs-9 align-middle ps-0">
                        <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox" data-bulk-select-row="{&quot;product&quot;:&quot;Razer Kraken v3 x Wired 7.1 Surroung Sound Gaming headset&quot;,&quot;productImage&quot;:&quot;/products/60x60/5.png&quot;,&quot;customer&quot;:{&quot;name&quot;:&quot;Kim Carroll&quot;,&quot;avatar&quot;:&quot;/team/40x40/avatar.webp&quot;,&quot;avatarPlaceholder&quot;:true},&quot;rating&quot;:4,&quot;review&quot;:&quot;It performs exactly as expected. There are three of these in the family.&quot;,&quot;status&quot;:{&quot;title&quot;:&quot;Pending&quot;,&quot;badge&quot;:&quot;warning&quot;,&quot;icon&quot;:&quot;clock&quot;},&quot;time&quot;:&quot;Nov 09, 2:15 PM&quot;}"></div>
                     </td>
                     <td class="align-middle product white-space-nowrap py-0"><a class="d-block rounded-2 border border-translucent" href="apps/e-commerce/landing/product-details.html"><img src="https://prium.github.io/phoenix/v1.22.0/assets/img/products/60x60/5.png" alt="" width="53"></a></td>
                     <td class="align-middle product white-space-nowrap"><a class="fw-semibold" href="apps/e-commerce/landing/product-details.html">Razer Kraken v3 x Wired 7.1 Surroung Sound Gam...</a></td>
                     <td class="align-middle customer white-space-nowrap">
                        <a class="d-flex align-items-center text-body" href="apps/e-commerce/landing/profile.html">
                           <div class="avatar avatar-l"><img class="rounded-circle avatar-placeholder" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/40x40/avatar.webp" alt=""></div>
                           <h6 class="mb-0 ms-3 text-body">Kim Carroll</h6>
                        </a>
                     </td>
                     <td class="align-middle rating white-space-nowrap fs-10">
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning-light" data-bs-theme="light" aria-hidden="true" focusable="false" data-prefix="far" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z"></path>
                        </svg>
                        <!-- <span class="fa-regular fa-star text-warning-light" data-bs-theme="light"></span> Font Awesome fontawesome.com -->
                     </td>
                     <td class="align-middle review" style="min-width:350px;">
                        <p class="fs-9 fw-semibold text-body-highlight mb-0">It performs exactly as expected. There are three of these in the family.</p>
                     </td>
                     <td class="align-middle text-start ps-5 status">
                        <span class="badge badge-phoenix fs-10 badge-phoenix-warning">
                           <span class="badge-label">Pending</span>
                           <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock ms-1" style="height:12.8px;width:12.8px;">
                              <circle cx="12" cy="12" r="10"></circle>
                              <polyline points="12 6 12 12 16 14"></polyline>
                           </svg>
                        </span>
                     </td>
                     <td class="align-middle text-end time white-space-nowrap">
                        <div class="hover-hide">
                           <h6 class="text-body-highlight mb-0">Nov 09, 2:15 PM</h6>
                        </div>
                     </td>
                     <td class="align-middle white-space-nowrap text-end pe-0">
                        <div class="position-relative">
                           <div class="hover-actions">
                              <button class="btn btn-sm btn-phoenix-secondary me-1 fs-10">
                                 <svg class="svg-inline--fa fa-check" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"></path>
                                 </svg>
                                 <!-- <span class="fas fa-check"></span> Font Awesome fontawesome.com -->
                              </button>
                              <button class="btn btn-sm btn-phoenix-secondary fs-10">
                                 <svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                                 </svg>
                                 <!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com -->
                              </button>
                           </div>
                        </div>
                        <div class="btn-reveal-trigger position-static">
                           <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                              <svg class="svg-inline--fa fa-ellipsis fs-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                 <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                              </svg>
                              <!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com -->
                           </button>
                           <div class="dropdown-menu dropdown-menu-end py-2">
                              <a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item text-danger" href="#!">Remove</a>
                           </div>
                        </div>
                     </td>
                  </tr>
                  <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                     <td class="fs-9 align-middle ps-0">
                        <div class="form-check mb-0 fs-8"><input class="form-check-input" type="checkbox" data-bulk-select-row="{&quot;product&quot;:&quot;PlayStation 5 DualSense Wireless Controller&quot;,&quot;productImage&quot;:&quot;/products/60x60/6.png&quot;,&quot;customer&quot;:{&quot;name&quot;:&quot;Barbara Lucas&quot;,&quot;avatar&quot;:&quot;/team/40x40/57.webp&quot;},&quot;rating&quot;:4,&quot;review&quot;:&quot;The controller is quite comfy for me. Despite its increased size, the controller still fits well in my hands.&quot;,&quot;status&quot;:{&quot;title&quot;:&quot;Approved&quot;,&quot;badge&quot;:&quot;success&quot;,&quot;icon&quot;:&quot;check&quot;},&quot;time&quot;:&quot;Nov 08, 8:53 AM&quot;}"></div>
                     </td>
                     <td class="align-middle product white-space-nowrap py-0"><a class="d-block rounded-2 border border-translucent" href="apps/e-commerce/landing/product-details.html"><img src="https://prium.github.io/phoenix/v1.22.0/assets/img/products/60x60/6.png" alt="" width="53"></a></td>
                     <td class="align-middle product white-space-nowrap"><a class="fw-semibold" href="apps/e-commerce/landing/product-details.html">PlayStation 5 DualSense Wireless Controller</a></td>
                     <td class="align-middle customer white-space-nowrap">
                        <a class="d-flex align-items-center text-body" href="apps/e-commerce/landing/profile.html">
                           <div class="avatar avatar-l"><img class="rounded-circle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/40x40/57.webp" alt=""></div>
                           <h6 class="mb-0 ms-3 text-body">Barbara Lucas</h6>
                        </a>
                     </td>
                     <td class="align-middle rating white-space-nowrap fs-10">
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                        </svg>
                        <!-- <span class="fa fa-star text-warning"></span> Font Awesome fontawesome.com -->
                        <svg class="svg-inline--fa fa-star text-warning-light" data-bs-theme="light" aria-hidden="true" focusable="false" data-prefix="far" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.7 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z"></path>
                        </svg>
                        <!-- <span class="fa-regular fa-star text-warning-light" data-bs-theme="light"></span> Font Awesome fontawesome.com -->
                     </td>
                     <td class="align-middle review" style="min-width:350px;">
                        <p class="fs-9 fw-semibold text-body-highlight mb-0">The controller is quite comfy for me. Despite its increased size, the controller still fits well in my hands.</p>
                     </td>
                     <td class="align-middle text-start ps-5 status">
                        <span class="badge badge-phoenix fs-10 badge-phoenix-success">
                           <span class="badge-label">Approved</span>
                           <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check ms-1" style="height:12.8px;width:12.8px;">
                              <polyline points="20 6 9 17 4 12"></polyline>
                           </svg>
                        </span>
                     </td>
                     <td class="align-middle text-end time white-space-nowrap">
                        <div class="hover-hide">
                           <h6 class="text-body-highlight mb-0">Nov 08, 8:53 AM</h6>
                        </div>
                     </td>
                     <td class="align-middle white-space-nowrap text-end pe-0">
                        <div class="position-relative">
                           <div class="hover-actions">
                              <button class="btn btn-sm btn-phoenix-secondary me-1 fs-10">
                                 <svg class="svg-inline--fa fa-check" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"></path>
                                 </svg>
                                 <!-- <span class="fas fa-check"></span> Font Awesome fontawesome.com -->
                              </button>
                              <button class="btn btn-sm btn-phoenix-secondary fs-10">
                                 <svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                                 </svg>
                                 <!-- <span class="fas fa-trash"></span> Font Awesome fontawesome.com -->
                              </button>
                           </div>
                        </div>
                        <div class="btn-reveal-trigger position-static">
                           <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                              <svg class="svg-inline--fa fa-ellipsis fs-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                 <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                              </svg>
                              <!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com -->
                           </button>
                           <div class="dropdown-menu dropdown-menu-end py-2">
                              <a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item text-danger" href="#!">Remove</a>
                           </div>
                        </div>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
         <div class="row align-items-center py-1">
            <div class="pagination d-none"></div>
            <div class="col d-flex fs-9">
               <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">1 to 6 <span class="text-body-tertiary"> Items of </span>15</p>
               <a class="fw-semibold" href="#!" data-list-view="*">
                  View all
                  <svg class="svg-inline--fa fa-angle-right ms-1" data-fa-transform="down-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="" style="transform-origin: 0.3125em 0.5625em;">
                     <g transform="translate(160 256)">
                        <g transform="translate(0, 32)  scale(1, 1)  rotate(0 0 0)">
                           <path fill="currentColor" d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z" transform="translate(-160 -256)"></path>
                        </g>
                     </g>
                  </svg>
                  <!-- <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span> Font Awesome fontawesome.com -->
               </a>
               <a class="fw-semibold d-none" href="#!" data-list-view="less">View Less</a>
            </div>
            <div class="col-auto d-flex">
               <button class="btn btn-link px-1 me-1 disabled" type="button" title="Previous" data-list-pagination="prev" disabled="">
                  <svg class="svg-inline--fa fa-chevron-left me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                     <path fill="currentColor" d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"></path>
                  </svg>
                  <!-- <span class="fas fa-chevron-left me-2"></span> Font Awesome fontawesome.com -->Previous
               </button>
               <button class="btn btn-link px-1 ms-1" type="button" title="Next" data-list-pagination="next">
                  Next
                  <svg class="svg-inline--fa fa-chevron-right ms-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                     <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                  </svg>
                  <!-- <span class="fas fa-chevron-right ms-2"></span> Font Awesome fontawesome.com -->
               </button>
            </div>
         </div>
      </div>
   </div>
   <h2 class="mb-5 mt-5">FAQ</h2>
   <h5 class="mb-3">How can we help?</h5>
   <p class="text-body-tertiary">Search for the topic you need help with or <a href="#!">contact our support</a></p>
   <div class="search-box mb-8 w-100" style="max-width:25rem;">
      <form class="position-relative">
         <input class="form-control search-input search" type="search" placeholder="Search" aria-label="Search">
         <svg class="svg-inline--fa fa-magnifying-glass search-box-icon" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="magnifying-glass" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
            <path fill="currentColor" d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path>
         </svg>
         <!-- <span class="fas fa-search search-box-icon"></span> Font Awesome fontawesome.com -->
      </form>
   </div>
   <div class="accordion" id="faqAccordion">
      <div class="accordion-item border-top">
         <h2 class="accordion-header" id="headingOne"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">What’s your return policy?</button></h2>
         <div class="accordion-collapse collapse" id="collapseOne" aria-labelledby="headingOne" data-bs-parent="#faqAccordion" style="">
            <div class="accordion-body pt-0">At the time of shipment, we assure that your product will be free of defects in materials and workmanship and will conform to the specifications outlined on the lot-specific datasheet included with the product. Please contact our technical support services if you have a technical issue with a product :<a href="mailto:phoenix@email.com">Email: phoenix@support.com.</a>If the team concludes that the product does not adhere to the requirements mentioned on the datasheet, we will provide a free replacement or a full refund of the product's invoice price.</div>
         </div>
      </div>
      <div class="accordion-item">
         <h2 class="accordion-header" id="headingTwo"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseOne">I ordered the wrong product. <br class="d-sm-none">What should I do?</button></h2>
         <div class="accordion-collapse collapse" id="collapseTwo" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion" style="">
            <div class="accordion-body pt-0">We would consider accepting the return of the merchandise, subject to an 20% restocking fee plus any shipping and handling fees. The customer is liable for shipping costs for both the returned product and the new replacement product, both to and from our facility. All returns require prior authorisation from us and must be mailed back to us within seven business days of receiving the goods. Products must be returned in the same or equivalent packing (i.e., cold and insulated) in which they were shipped (i.e., cold and insulated). Once we get the item, we will ship out the replacement item.</div>
         </div>
      </div>
      <div class="accordion-item">
         <h2 class="accordion-header" id="headingThree"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseOne">How do I cancel my order?</button></h2>
         <div class="accordion-collapse collapse" id="collapseThree" aria-labelledby="headingThree" data-bs-parent="#faqAccordion" style="">
            <div class="accordion-body pt-0">If you must cancel your order, please call <a href="tel:+871406-7509">(871) 406-7509</a> Please note that we attempt to process and dispatch orders the same day (if received before 1pm PST), and once your product has shipped, our return policy will apply.</div>
         </div>
      </div>
      <div class="accordion-item">
         <h2 class="accordion-header" id="headingFour"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseOne">What are your shipping &amp; <br class="d-sm-none">handling charges?</button></h2>
         <div class="accordion-collapse collapse show" id="collapseFour" aria-labelledby="headingFour" data-bs-parent="#faqAccordion" style="">
            <div class="accordion-body pt-0">Our handling fee is a flat rate of $20. The shipping costs vary depending on your location and the items you've purchased. For an exact shipping cost estimate, please proceed through the checkout process and enter your items and address.</div>
         </div>
      </div>
      <div class="accordion-item">
         <h2 class="accordion-header" id="headingFive"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseOne">Do you accept purchase orders?</button></h2>
         <div class="accordion-collapse collapse" id="collapseFive" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
            <div class="accordion-body pt-0">Yes. Please include your purchase order number at online checkout, or clearly label it on a faxed or emailed purchase order. Please give the relevant email or mailing address for your accounts payable department so that the invoice can be sent to the appropriate location.</div>
         </div>
      </div>
   </div>
   <div class="text-center py-11">
      <h3 class="text-body-emphasis">Still can’t find your answer?</h3>
      <p class="text-body">We are happy to help</p>
      <button class="btn btn-sm btn-outline-primary btn-support-chat">
         <svg class="svg-inline--fa fa-comment me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="comment" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
            <path fill="currentColor" d="M512 240c0 114.9-114.6 208-256 208c-37.1 0-72.3-6.4-104.1-17.9c-11.9 8.7-31.3 20.6-54.3 30.6C73.6 471.1 44.7 480 16 480c-6.5 0-12.3-3.9-14.8-9.9c-2.5-6-1.1-12.8 3.4-17.4l0 0 0 0 0 0 0 0 .3-.3c.3-.3 .7-.7 1.3-1.4c1.1-1.2 2.8-3.1 4.9-5.7c4.1-5 9.6-12.4 15.2-21.6c10-16.6 19.5-38.4 21.4-62.9C17.7 326.8 0 285.1 0 240C0 125.1 114.6 32 256 32s256 93.1 256 208z"></path>
         </svg>
         <!-- <span class="fas fa-comment me-2"></span> Font Awesome fontawesome.com -->Chat with us
      </button>
   </div>
   <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis pt-7 mt-5 border-y">
      <h2 class="mb-5">Notifications</h2>
      <h5 class="text-body-emphasis mb-3">Today</h5>
      <div class="mx-n4 mx-lg-n6 mb-5 border-bottom">
         <div class="d-flex align-items-center justify-content-between py-3 px-lg-6 px-4 notification-card border-top read">
            <div class="d-flex">
               <div class="avatar avatar-xl me-3"><img class="rounded-circle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/40x40/30.webp" alt=""></div>
               <div class="me-3 flex-1 mt-2">
                  <h4 class="fs-9 text-body-emphasis">Jessie Samson</h4>
                  <p class="fs-9 text-body-highlight"><span class="me-1">💬</span>Mentioned you in a comment<span class="fw-bold"> "Well done! Proud of you ❤️ " </span><span class="ms-2 text-body-tertiary text-opacity-85 fw-bold fs-10">10m</span></p>
                  <p class="text-body-secondary fs-9 mb-0">
                     <svg class="svg-inline--fa fa-clock me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="clock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                        <path fill="currentColor" d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path>
                     </svg>
                     <!-- <span class="me-1 fas fa-clock"></span> Font Awesome fontawesome.com --><span class="fw-bold">10:41 AM </span>August 7,2021
                  </p>
               </div>
            </div>
            <div class="dropdown">
               <button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                  <svg class="svg-inline--fa fa-ellipsis fs-10 text-body" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                     <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                  </svg>
                  <!-- <span class="fas fa-ellipsis-h fs-10 text-body"></span> Font Awesome fontawesome.com -->
               </button>
               <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
            </div>
         </div>
         <div class="d-flex align-items-center justify-content-between py-3 px-lg-6 px-4 notification-card border-top unread">
            <div class="d-flex">
               <div class="avatar avatar-xl me-3">
                  <div class="avatar-name rounded-circle"><span>J</span></div>
               </div>
               <div class="me-3 flex-1 mt-2">
                  <h4 class="fs-9 text-body-emphasis">Jane Foster</h4>
                  <p class="fs-9 text-body-highlight"><span class="me-1">📅</span>Created an event<span class="fw-bold"> Rome holidays</span><span class="ms-2 text-body-tertiary text-opacity-85 fw-bold fs-10">20m</span></p>
                  <p class="text-body-secondary fs-9 mb-0">
                     <svg class="svg-inline--fa fa-clock me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="clock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                        <path fill="currentColor" d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path>
                     </svg>
                     <!-- <span class="me-1 fas fa-clock"></span> Font Awesome fontawesome.com --><span class="fw-bold">10:20 AM </span>August 7,2021
                  </p>
               </div>
            </div>
            <div class="dropdown">
               <button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                  <svg class="svg-inline--fa fa-ellipsis fs-10 text-body" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                     <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                  </svg>
                  <!-- <span class="fas fa-ellipsis-h fs-10 text-body"></span> Font Awesome fontawesome.com -->
               </button>
               <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
            </div>
         </div>
         <div class="d-flex align-items-center justify-content-between py-3 px-lg-6 px-4 notification-card border-top unread">
            <div class="d-flex">
               <div class="avatar avatar-xl me-3"><img class="rounded-circle avatar-placeholder" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/40x40/avatar.webp" alt=""></div>
               <div class="me-3 flex-1 mt-2">
                  <h4 class="fs-9 text-body-emphasis">Jessie Samson</h4>
                  <p class="fs-9 text-body-highlight"><span class="me-1">👍</span>Liked your comment<span class="fw-bold"> "Amazing Works️"</span><span class="ms-2 text-body-tertiary text-opacity-85 fw-bold fs-10">1h</span></p>
                  <p class="text-body-secondary fs-9 mb-0">
                     <svg class="svg-inline--fa fa-clock me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="clock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                        <path fill="currentColor" d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path>
                     </svg>
                     <!-- <span class="me-1 fas fa-clock"></span> Font Awesome fontawesome.com --><span class="fw-bold">9:30 AM </span>August 7,2021
                  </p>
               </div>
            </div>
            <div class="dropdown">
               <button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                  <svg class="svg-inline--fa fa-ellipsis fs-10 text-body" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                     <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                  </svg>
                  <!-- <span class="fas fa-ellipsis-h fs-10 text-body"></span> Font Awesome fontawesome.com -->
               </button>
               <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
            </div>
         </div>
      </div>
      <h5 class="text-semibold text-body-emphasis mb-3">Yesterday</h5>
      <div class="mx-n4 mx-lg-n6 mb-9 border-bottom">
         <div class="d-flex align-items-center justify-content-between py-3 px-lg-6 px-4 notification-card border-top unread">
            <div class="d-flex">
               <div class="avatar avatar-xl me-3"><img class="rounded-circle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/40x40/57.webp" alt=""></div>
               <div class="me-3 flex-1 mt-2">
                  <h4 class="fs-9 text-body-emphasis">Kiera Anderson</h4>
                  <p class="fs-9 text-body-highlight"><span class="me-1">💬</span>Mentioned you in a comment<span class="fw-bold"> "This is too good to be true!"</span><span class="ms-2 text-body-tertiary text-opacity-85 fw-bold fs-10"></span></p>
                  <p class="text-body-secondary fs-9 mb-0">
                     <svg class="svg-inline--fa fa-clock me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="clock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                        <path fill="currentColor" d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path>
                     </svg>
                     <!-- <span class="me-1 fas fa-clock"></span> Font Awesome fontawesome.com --><span class="fw-bold">9:11 AM </span>August 7,2021
                  </p>
               </div>
            </div>
            <div class="dropdown">
               <button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                  <svg class="svg-inline--fa fa-ellipsis fs-10 text-body" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                     <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                  </svg>
                  <!-- <span class="fas fa-ellipsis-h fs-10 text-body"></span> Font Awesome fontawesome.com -->
               </button>
               <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
            </div>
         </div>
         <div class="d-flex align-items-center justify-content-between py-3 px-lg-6 px-4 notification-card border-top unread">
            <div class="d-flex">
               <div class="avatar avatar-xl me-3"><img class="rounded-circle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/40x40/59.webp" alt=""></div>
               <div class="me-3 flex-1 mt-2">
                  <h4 class="fs-9 text-body-emphasis">Herman Carter</h4>
                  <p class="fs-9 text-body-highlight"><span class="me-1">👤</span>Tagged you in a<span class="fw-bold"> post</span><span class="ms-2 text-body-tertiary text-opacity-85 fw-bold fs-10"></span></p>
                  <p class="text-body-secondary fs-9 mb-0">
                     <svg class="svg-inline--fa fa-clock me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="clock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                        <path fill="currentColor" d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path>
                     </svg>
                     <!-- <span class="me-1 fas fa-clock"></span> Font Awesome fontawesome.com --><span class="fw-bold">10:58 PM </span>August 7,2021
                  </p>
               </div>
            </div>
            <div class="dropdown">
               <button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                  <svg class="svg-inline--fa fa-ellipsis fs-10 text-body" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                     <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                  </svg>
                  <!-- <span class="fas fa-ellipsis-h fs-10 text-body"></span> Font Awesome fontawesome.com -->
               </button>
               <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
            </div>
         </div>
         <div class="d-flex align-items-center justify-content-between py-3 px-lg-6 px-4 notification-card border-top read">
            <div class="d-flex">
               <div class="avatar avatar-xl me-3"><img class="rounded-circle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/40x40/58.webp" alt=""></div>
               <div class="me-3 flex-1 mt-2">
                  <h4 class="fs-9 text-body-emphasis">Benjamin Button</h4>
                  <p class="fs-9 text-body-highlight"><span class="me-1">👍</span>Liked your comment<span class="fw-bold"> "Welcome to the team️"</span><span class="ms-2 text-body-tertiary text-opacity-85 fw-bold fs-10"></span></p>
                  <p class="text-body-secondary fs-9 mb-0">
                     <svg class="svg-inline--fa fa-clock me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="clock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                        <path fill="currentColor" d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path>
                     </svg>
                     <!-- <span class="me-1 fas fa-clock"></span> Font Awesome fontawesome.com --><span class="fw-bold">10:18 AM </span>August 7,2021
                  </p>
               </div>
            </div>
            <div class="dropdown">
               <button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                  <svg class="svg-inline--fa fa-ellipsis fs-10 text-body" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                     <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                  </svg>
                  <!-- <span class="fas fa-ellipsis-h fs-10 text-body"></span> Font Awesome fontawesome.com -->
               </button>
               <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
            </div>
         </div>
         <div class="d-flex align-items-center justify-content-between py-3 px-lg-6 px-4 notification-card border-top read">
            <div class="d-flex">
               <div class="avatar avatar-xl me-3"><img class="rounded-circle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/40x40/60.webp" alt=""></div>
               <div class="me-3 flex-1 mt-2">
                  <h4 class="fs-9 text-body-emphasis">Aron Paul</h4>
                  <p class="fs-9 text-body-highlight"><span class="me-1">📷</span>Tagged you in a<span class="fw-bold"> photo</span><span class="ms-2 text-body-tertiary text-opacity-85 fw-bold fs-10"></span></p>
                  <p class="text-body-secondary fs-9 mb-0">
                     <svg class="svg-inline--fa fa-clock me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="clock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                        <path fill="currentColor" d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path>
                     </svg>
                     <!-- <span class="me-1 fas fa-clock"></span> Font Awesome fontawesome.com --><span class="fw-bold">9:53 AM </span>August 7,2021
                  </p>
               </div>
            </div>
            <div class="dropdown">
               <button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                  <svg class="svg-inline--fa fa-ellipsis fs-10 text-body" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                     <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                  </svg>
                  <!-- <span class="fas fa-ellipsis-h fs-10 text-body"></span> Font Awesome fontawesome.com -->
               </button>
               <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
            </div>
         </div>
         <div class="d-flex align-items-center justify-content-between py-3 px-lg-6 px-4 notification-card border-top read">
            <div class="d-flex">
               <div class="avatar avatar-xl me-3"><img class="rounded-circle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/40x40/34.webp" alt=""></div>
               <div class="me-3 flex-1 mt-2">
                  <h4 class="fs-9 text-body-emphasis">Rick Sanchez</h4>
                  <p class="fs-9 text-body-highlight"><span class="me-1">💬</span>Mentioned you in a comment<span class="fw-bold"> "You need to see these amazing photos️"</span><span class="ms-2 text-body-tertiary text-opacity-85 fw-bold fs-10"></span></p>
                  <p class="text-body-secondary fs-9 mb-0">
                     <svg class="svg-inline--fa fa-clock me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="clock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                        <path fill="currentColor" d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path>
                     </svg>
                     <!-- <span class="me-1 fas fa-clock"></span> Font Awesome fontawesome.com --><span class="fw-bold">9:45 AM </span>August 7,2021
                  </p>
               </div>
            </div>
            <div class="dropdown">
               <button class="btn fs-10 btn-sm dropdown-toggle dropdown-caret-none transition-none notification-dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                  <svg class="svg-inline--fa fa-ellipsis fs-10 text-body" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                     <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                  </svg>
                  <!-- <span class="fas fa-ellipsis-h fs-10 text-body"></span> Font Awesome fontawesome.com -->
               </button>
               <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Mark as unread</a></div>
            </div>
         </div>
      </div>
      <div class="col-12">
         <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis pt-6 border-top">
            <div id="projectSummary" data-list="{&quot;valueNames&quot;:[&quot;project&quot;,&quot;assignees&quot;,&quot;start&quot;,&quot;deadline&quot;,&quot;calculation&quot;,&quot;projectprogress&quot;,&quot;status&quot;,&quot;action&quot;],&quot;page&quot;:6,&quot;pagination&quot;:true}">
               <div class="row align-items-end justify-content-between pb-4 g-3">
                  <div class="col-auto">
                     <h3>Projects</h3>
                     <p class="text-body-tertiary lh-sm mb-0">Brief summary of all projects</p>
                  </div>
               </div>
               <div class="table-responsive ms-n1 ps-1 scrollbar">
                  <table class="table fs-9 mb-0 border-top border-translucent">
                     <thead>
                        <tr>
                           <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="project" style="width:30%;">PROJECT NAME</th>
                           <th class="sort align-middle ps-3" scope="col" data-sort="assignees" style="width:10%;">Assignees</th>
                           <th class="sort align-middle ps-3" scope="col" data-sort="start" style="width:10%;">START DATE</th>
                           <th class="sort align-middle ps-3" scope="col" data-sort="deadline" style="width:15%;">DEADLINE</th>
                           <th class="sort align-middle ps-3" scope="col" data-sort="calculation" style="width:12%;">CALCULATION</th>
                           <th class="sort align-middle ps-3" scope="col" data-sort="projectprogress" style="width:5%;">PROGRESS</th>
                           <th class="align-middle ps-8" scope="col" data-sort="status" style="width:10%;">STATUS</th>
                           <th class="sort align-middle text-end" scope="col" style="width:10%;"></th>
                        </tr>
                     </thead>
                     <tbody class="list" id="project-summary-table-body">
                        <tr class="position-static">
                           <td class="align-middle time white-space-nowrap ps-0 project"><a class="fw-bold fs-8" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#">Making the Butterflies shoot each other dead</a></td>
                           <td class="align-middle white-space-nowrap assignees ps-3">
                              <div class="avatar-group avatar-group-dense">
                                 <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <div class="avatar avatar-s  rounded-circle">
                                       <img class="rounded-circle " src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/9.webp" alt="">
                                    </div>
                                 </a>
                                 <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                    <div class="position-relative">
                                       <div class="bg-holder z-n1" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/bg/bg-32.png);background-size: auto;"></div>
                                       <!--/.bg-holder-->
                                       <div class="p-3">
                                          <div class="text-end">
                                             <button class="btn p-0 me-2">
                                                <svg class="svg-inline--fa fa-user-plus text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-user-plus text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn p-0">
                                                <svg class="svg-inline--fa fa-ellipsis text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-ellipsis text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                          <div class="text-center">
                                             <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/9.webp" alt=""></div>
                                             <h6 class="text-white">Michael Jenkins</h6>
                                             <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                             <div class="d-flex flex-center mb-3">
                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6>
                                                <svg class="svg-inline--fa fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.375em;">
                                                   <g transform="translate(256 256)">
                                                      <g transform="translate(0, -64)  scale(0.375, 0.375)  rotate(0 0 0)">
                                                         <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" transform="translate(-256 -256)"></path>
                                                      </g>
                                                   </g>
                                                </svg>
                                                <!-- <span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span> Font Awesome fontawesome.com -->
                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="bg-body-emphasis">
                                       <div class="p-3 border-bottom border-translucent">
                                          <div class="d-flex justify-content-between">
                                             <div class="d-flex">
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-phone" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-phone"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-message" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-message"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg">
                                                   <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-video"></span> Font Awesome fontawesome.com -->
                                                </button>
                                             </div>
                                             <button class="btn btn-phoenix-primary">
                                                <svg class="svg-inline--fa fa-envelope me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com -->Send Email
                                             </button>
                                          </div>
                                       </div>
                                       <ul class="nav d-flex flex-column py-3 border-bottom">
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard me-2 text-body d-inline-block">
                                                   <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                   <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                </svg>
                                                <span class="text-body-highlight flex-1">Assigned Projects</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body">
                                                   <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                   <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                                </svg>
                                                <span class="text-body-highlight flex-1">View activiy</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Unassign </a></div>
                                 </div>
                                 <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <div class="avatar avatar-s  rounded-circle">
                                       <img class="rounded-circle " src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/25.webp" alt="">
                                    </div>
                                 </a>
                                 <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                    <div class="position-relative">
                                       <div class="bg-holder z-n1" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/bg/bg-32.png);background-size: auto;"></div>
                                       <!--/.bg-holder-->
                                       <div class="p-3">
                                          <div class="text-end">
                                             <button class="btn p-0 me-2">
                                                <svg class="svg-inline--fa fa-user-plus text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-user-plus text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn p-0">
                                                <svg class="svg-inline--fa fa-ellipsis text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-ellipsis text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                          <div class="text-center">
                                             <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/25.webp" alt=""></div>
                                             <h6 class="text-white">Ansolo Lazinatov</h6>
                                             <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                             <div class="d-flex flex-center mb-3">
                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6>
                                                <svg class="svg-inline--fa fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.375em;">
                                                   <g transform="translate(256 256)">
                                                      <g transform="translate(0, -64)  scale(0.375, 0.375)  rotate(0 0 0)">
                                                         <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" transform="translate(-256 -256)"></path>
                                                      </g>
                                                   </g>
                                                </svg>
                                                <!-- <span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span> Font Awesome fontawesome.com -->
                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="bg-body-emphasis">
                                       <div class="p-3 border-bottom border-translucent">
                                          <div class="d-flex justify-content-between">
                                             <div class="d-flex">
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-phone" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-phone"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-message" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-message"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg">
                                                   <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-video"></span> Font Awesome fontawesome.com -->
                                                </button>
                                             </div>
                                             <button class="btn btn-phoenix-primary">
                                                <svg class="svg-inline--fa fa-envelope me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com -->Send Email
                                             </button>
                                          </div>
                                       </div>
                                       <ul class="nav d-flex flex-column py-3 border-bottom">
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard me-2 text-body d-inline-block">
                                                   <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                   <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                </svg>
                                                <span class="text-body-highlight flex-1">Assigned Projects</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body">
                                                   <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                   <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                                </svg>
                                                <span class="text-body-highlight flex-1">View activiy</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Unassign </a></div>
                                 </div>
                                 <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <div class="avatar avatar-s  rounded-circle">
                                       <img class="rounded-circle " src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/32.webp" alt="">
                                    </div>
                                 </a>
                                 <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                    <div class="position-relative">
                                       <div class="bg-holder z-n1" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/bg/bg-32.png);background-size: auto;"></div>
                                       <!--/.bg-holder-->
                                       <div class="p-3">
                                          <div class="text-end">
                                             <button class="btn p-0 me-2">
                                                <svg class="svg-inline--fa fa-user-plus text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-user-plus text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn p-0">
                                                <svg class="svg-inline--fa fa-ellipsis text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-ellipsis text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                          <div class="text-center">
                                             <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/32.webp" alt=""></div>
                                             <h6 class="text-white">Jennifer Schramm</h6>
                                             <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                             <div class="d-flex flex-center mb-3">
                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6>
                                                <svg class="svg-inline--fa fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.375em;">
                                                   <g transform="translate(256 256)">
                                                      <g transform="translate(0, -64)  scale(0.375, 0.375)  rotate(0 0 0)">
                                                         <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" transform="translate(-256 -256)"></path>
                                                      </g>
                                                   </g>
                                                </svg>
                                                <!-- <span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span> Font Awesome fontawesome.com -->
                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="bg-body-emphasis">
                                       <div class="p-3 border-bottom border-translucent">
                                          <div class="d-flex justify-content-between">
                                             <div class="d-flex">
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-phone" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-phone"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-message" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-message"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg">
                                                   <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-video"></span> Font Awesome fontawesome.com -->
                                                </button>
                                             </div>
                                             <button class="btn btn-phoenix-primary">
                                                <svg class="svg-inline--fa fa-envelope me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com -->Send Email
                                             </button>
                                          </div>
                                       </div>
                                       <ul class="nav d-flex flex-column py-3 border-bottom">
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard me-2 text-body d-inline-block">
                                                   <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                   <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                </svg>
                                                <span class="text-body-highlight flex-1">Assigned Projects</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body">
                                                   <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                   <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                                </svg>
                                                <span class="text-body-highlight flex-1">View activiy</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Unassign </a></div>
                                 </div>
                                 <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <div class="avatar avatar-s  rounded-circle">
                                       <img class="rounded-circle avatar-placeholder" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/avatar.webp" alt="">
                                    </div>
                                 </a>
                                 <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                    <div class="position-relative">
                                       <div class="bg-holder z-n1" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/bg/bg-32.png);background-size: auto;"></div>
                                       <!--/.bg-holder-->
                                       <div class="p-3">
                                          <div class="text-end">
                                             <button class="btn p-0 me-2">
                                                <svg class="svg-inline--fa fa-user-plus text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-user-plus text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn p-0">
                                                <svg class="svg-inline--fa fa-ellipsis text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-ellipsis text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                          <div class="text-center">
                                             <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/avatar.webp" alt=""></div>
                                             <h6 class="text-white">Kristine Cadena</h6>
                                             <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                             <div class="d-flex flex-center mb-3">
                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6>
                                                <svg class="svg-inline--fa fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.375em;">
                                                   <g transform="translate(256 256)">
                                                      <g transform="translate(0, -64)  scale(0.375, 0.375)  rotate(0 0 0)">
                                                         <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" transform="translate(-256 -256)"></path>
                                                      </g>
                                                   </g>
                                                </svg>
                                                <!-- <span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span> Font Awesome fontawesome.com -->
                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="bg-body-emphasis">
                                       <div class="p-3 border-bottom border-translucent">
                                          <div class="d-flex justify-content-between">
                                             <div class="d-flex">
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-phone" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-phone"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-message" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-message"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg">
                                                   <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-video"></span> Font Awesome fontawesome.com -->
                                                </button>
                                             </div>
                                             <button class="btn btn-phoenix-primary">
                                                <svg class="svg-inline--fa fa-envelope me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com -->Send Email
                                             </button>
                                          </div>
                                       </div>
                                       <ul class="nav d-flex flex-column py-3 border-bottom">
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard me-2 text-body d-inline-block">
                                                   <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                   <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                </svg>
                                                <span class="text-body-highlight flex-1">Assigned Projects</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body">
                                                   <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                   <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                                </svg>
                                                <span class="text-body-highlight flex-1">View activiy</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Unassign </a></div>
                                 </div>
                                 <div class="avatar avatar-s  rounded-circle">
                                    <div class="avatar-name rounded-circle "><span>+3</span></div>
                                 </div>
                              </div>
                           </td>
                           <td class="align-middle white-space-nowrap start ps-3">
                              <p class="mb-0 fs-9 text-body">Dec 12, 2018</p>
                           </td>
                           <td class="align-middle white-space-nowrap deadline ps-3">
                              <p class="mb-0 fs-9 text-body">Dec 12, 2026</p>
                           </td>
                           <td class="align-middle white-space-nowrap calculation ps-3">
                              <p class="fw-bold text-body-emphasis fs-9 mb-0">$4</p>
                              <p class="fw-semibold fs-10 text-body-tertiary mb-0">Cost</p>
                           </td>
                           <td class="align-middle white-space-nowrap ps-3 projectprogress">
                              <p class="text-body-secondary fs-10 mb-0">145 / 145</p>
                              <div class="progress" style="height:3px;">
                                 <div class="progress-bar bg-success" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" role="progressbar"></div>
                              </div>
                           </td>
                           <td class="align-middle white-space-nowrap ps-8">
                              <div class="progress progress-stack mt-3" style="height:3px;">
                                 <div class="progress-bar bg-info" style="width:30%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" role="progressbar" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Active" data-bs-original-title="Active"></div>
                                 <div class="progress-bar bg-danger" style="width:5%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" role="progressbar" aria-label="Damage" data-bs-original-title="Damage"></div>
                                 <div class="progress-bar bg-warning" style="width:45%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" role="progressbar" aria-label="Pending" data-bs-original-title="Pending"></div>
                                 <div class="progress-bar bg-success" style="width:15%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" role="progressbar" aria-label="Done" data-bs-original-title="Done"></div>
                              </div>
                           </td>
                           <td class="align-middle text-end white-space-nowrap pe-0 action">
                              <div class="btn-reveal-trigger position-static">
                                 <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                    <svg class="svg-inline--fa fa-ellipsis fs-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                       <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                    </svg>
                                    <!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com -->
                                 </button>
                                 <div class="dropdown-menu dropdown-menu-end py-2">
                                    <a class="dropdown-item" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">View</a><a class="dropdown-item" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Export</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Remove</a>
                                 </div>
                              </div>
                           </td>
                        </tr>
                        <tr class="position-static">
                           <td class="align-middle time white-space-nowrap ps-0 project"><a class="fw-bold fs-8" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#">Project Doughnut Dungeon</a></td>
                           <td class="align-middle white-space-nowrap assignees ps-3">
                              <div class="avatar-group avatar-group-dense">
                                 <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <div class="avatar avatar-s  rounded-circle">
                                       <img class="rounded-circle " src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/22.webp" alt="">
                                    </div>
                                 </a>
                                 <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                    <div class="position-relative">
                                       <div class="bg-holder z-n1" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/bg/bg-32.png);background-size: auto;"></div>
                                       <!--/.bg-holder-->
                                       <div class="p-3">
                                          <div class="text-end">
                                             <button class="btn p-0 me-2">
                                                <svg class="svg-inline--fa fa-user-plus text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-user-plus text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn p-0">
                                                <svg class="svg-inline--fa fa-ellipsis text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-ellipsis text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                          <div class="text-center">
                                             <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/22.webp" alt=""></div>
                                             <h6 class="text-white">Woodrow Burton</h6>
                                             <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                             <div class="d-flex flex-center mb-3">
                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6>
                                                <svg class="svg-inline--fa fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.375em;">
                                                   <g transform="translate(256 256)">
                                                      <g transform="translate(0, -64)  scale(0.375, 0.375)  rotate(0 0 0)">
                                                         <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" transform="translate(-256 -256)"></path>
                                                      </g>
                                                   </g>
                                                </svg>
                                                <!-- <span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span> Font Awesome fontawesome.com -->
                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="bg-body-emphasis">
                                       <div class="p-3 border-bottom border-translucent">
                                          <div class="d-flex justify-content-between">
                                             <div class="d-flex">
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-phone" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-phone"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-message" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-message"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg">
                                                   <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-video"></span> Font Awesome fontawesome.com -->
                                                </button>
                                             </div>
                                             <button class="btn btn-phoenix-primary">
                                                <svg class="svg-inline--fa fa-envelope me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com -->Send Email
                                             </button>
                                          </div>
                                       </div>
                                       <ul class="nav d-flex flex-column py-3 border-bottom">
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard me-2 text-body d-inline-block">
                                                   <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                   <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                </svg>
                                                <span class="text-body-highlight flex-1">Assigned Projects</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body">
                                                   <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                   <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                                </svg>
                                                <span class="text-body-highlight flex-1">View activiy</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Unassign </a></div>
                                 </div>
                                 <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <div class="avatar avatar-s  rounded-circle">
                                       <img class="rounded-circle " src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/28.webp" alt="">
                                    </div>
                                 </a>
                                 <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                    <div class="position-relative">
                                       <div class="bg-holder z-n1" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/bg/bg-32.png);background-size: auto;"></div>
                                       <!--/.bg-holder-->
                                       <div class="p-3">
                                          <div class="text-end">
                                             <button class="btn p-0 me-2">
                                                <svg class="svg-inline--fa fa-user-plus text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-user-plus text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn p-0">
                                                <svg class="svg-inline--fa fa-ellipsis text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-ellipsis text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                          <div class="text-center">
                                             <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/28.webp" alt=""></div>
                                             <h6 class="text-white">Ashley Garrett</h6>
                                             <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                             <div class="d-flex flex-center mb-3">
                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6>
                                                <svg class="svg-inline--fa fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.375em;">
                                                   <g transform="translate(256 256)">
                                                      <g transform="translate(0, -64)  scale(0.375, 0.375)  rotate(0 0 0)">
                                                         <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" transform="translate(-256 -256)"></path>
                                                      </g>
                                                   </g>
                                                </svg>
                                                <!-- <span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span> Font Awesome fontawesome.com -->
                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="bg-body-emphasis">
                                       <div class="p-3 border-bottom border-translucent">
                                          <div class="d-flex justify-content-between">
                                             <div class="d-flex">
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-phone" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-phone"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-message" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-message"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg">
                                                   <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-video"></span> Font Awesome fontawesome.com -->
                                                </button>
                                             </div>
                                             <button class="btn btn-phoenix-primary">
                                                <svg class="svg-inline--fa fa-envelope me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com -->Send Email
                                             </button>
                                          </div>
                                       </div>
                                       <ul class="nav d-flex flex-column py-3 border-bottom">
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard me-2 text-body d-inline-block">
                                                   <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                   <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                </svg>
                                                <span class="text-body-highlight flex-1">Assigned Projects</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body">
                                                   <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                   <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                                </svg>
                                                <span class="text-body-highlight flex-1">View activiy</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Unassign </a></div>
                                 </div>
                                 <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <div class="avatar avatar-s">
                                       <div class="avatar-name rounded-circle"><span>R</span></div>
                                    </div>
                                 </a>
                                 <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                    <div class="position-relative">
                                       <div class="bg-holder z-n1" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/bg/bg-32.png);background-size: auto;"></div>
                                       <!--/.bg-holder-->
                                       <div class="p-3">
                                          <div class="text-end">
                                             <button class="btn p-0 me-2">
                                                <svg class="svg-inline--fa fa-user-plus text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-user-plus text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn p-0">
                                                <svg class="svg-inline--fa fa-ellipsis text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-ellipsis text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                          <div class="text-center">
                                             <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2">
                                                <div class="avatar-name rounded-circle"><span>R</span></div>
                                             </div>
                                             <h6 class="text-white">Raymond Mims</h6>
                                             <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                             <div class="d-flex flex-center mb-3">
                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6>
                                                <svg class="svg-inline--fa fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.375em;">
                                                   <g transform="translate(256 256)">
                                                      <g transform="translate(0, -64)  scale(0.375, 0.375)  rotate(0 0 0)">
                                                         <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" transform="translate(-256 -256)"></path>
                                                      </g>
                                                   </g>
                                                </svg>
                                                <!-- <span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span> Font Awesome fontawesome.com -->
                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="bg-body-emphasis">
                                       <div class="p-3 border-bottom border-translucent">
                                          <div class="d-flex justify-content-between">
                                             <div class="d-flex">
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-phone" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-phone"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-message" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-message"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg">
                                                   <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-video"></span> Font Awesome fontawesome.com -->
                                                </button>
                                             </div>
                                             <button class="btn btn-phoenix-primary">
                                                <svg class="svg-inline--fa fa-envelope me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com -->Send Email
                                             </button>
                                          </div>
                                       </div>
                                       <ul class="nav d-flex flex-column py-3 border-bottom">
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard me-2 text-body d-inline-block">
                                                   <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                   <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                </svg>
                                                <span class="text-body-highlight flex-1">Assigned Projects</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body">
                                                   <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                   <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                                </svg>
                                                <span class="text-body-highlight flex-1">View activiy</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Unassign </a></div>
                                 </div>
                              </div>
                           </td>
                           <td class="align-middle white-space-nowrap start ps-3">
                              <p class="mb-0 fs-9 text-body">Jan 9, 2019</p>
                           </td>
                           <td class="align-middle white-space-nowrap deadline ps-3">
                              <p class="mb-0 fs-9 text-body">Dec 9, 2022</p>
                           </td>
                           <td class="align-middle white-space-nowrap calculation ps-3">
                              <button class="btn btn-phoenix-secondary btn-square-sm">
                                 <svg class="svg-inline--fa fa-plus" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"></path>
                                 </svg>
                                 <!-- <span class="fas fa-plus"></span> Font Awesome fontawesome.com -->
                              </button>
                           </td>
                           <td class="align-middle white-space-nowrap ps-3 projectprogress">
                              <p class="text-body-secondary fs-10 mb-0">148 / 223</p>
                              <div class="progress" style="height:3px;">
                                 <div class="progress-bar bg-success" style="width: 66.3677130044843%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" role="progressbar"></div>
                              </div>
                           </td>
                           <td class="align-middle white-space-nowrap ps-8">
                              <div class="progress progress-stack mt-3" style="height:3px;">
                                 <div class="progress-bar bg-info" style="width:20%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" role="progressbar" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Active" data-bs-original-title="Active"></div>
                                 <div class="progress-bar bg-danger" style="width:15%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" role="progressbar" aria-label="Damage" data-bs-original-title="Damage"></div>
                                 <div class="progress-bar bg-warning" style="width:45%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" role="progressbar" aria-label="Pending" data-bs-original-title="Pending"></div>
                                 <div class="progress-bar bg-success" style="width:30%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" role="progressbar" aria-label="Done" data-bs-original-title="Done"></div>
                              </div>
                           </td>
                           <td class="align-middle text-end white-space-nowrap pe-0 action">
                              <div class="btn-reveal-trigger position-static">
                                 <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                    <svg class="svg-inline--fa fa-ellipsis fs-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                       <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                    </svg>
                                    <!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com -->
                                 </button>
                                 <div class="dropdown-menu dropdown-menu-end py-2">
                                    <a class="dropdown-item" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">View</a><a class="dropdown-item" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Export</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Remove</a>
                                 </div>
                              </div>
                           </td>
                        </tr>
                        <tr class="position-static">
                           <td class="align-middle time white-space-nowrap ps-0 project"><a class="fw-bold fs-8" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#">The Chewing Gum Attack</a></td>
                           <td class="align-middle white-space-nowrap assignees ps-3">
                              <div class="avatar-group avatar-group-dense">
                                 <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <div class="avatar avatar-s  rounded-circle">
                                       <img class="rounded-circle " src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/34.webp" alt="">
                                    </div>
                                 </a>
                                 <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                    <div class="position-relative">
                                       <div class="bg-holder z-n1" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/bg/bg-32.png);background-size: auto;"></div>
                                       <!--/.bg-holder-->
                                       <div class="p-3">
                                          <div class="text-end">
                                             <button class="btn p-0 me-2">
                                                <svg class="svg-inline--fa fa-user-plus text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-user-plus text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn p-0">
                                                <svg class="svg-inline--fa fa-ellipsis text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-ellipsis text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                          <div class="text-center">
                                             <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/34.webp" alt=""></div>
                                             <h6 class="text-white">Jean Renoir</h6>
                                             <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                             <div class="d-flex flex-center mb-3">
                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6>
                                                <svg class="svg-inline--fa fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.375em;">
                                                   <g transform="translate(256 256)">
                                                      <g transform="translate(0, -64)  scale(0.375, 0.375)  rotate(0 0 0)">
                                                         <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" transform="translate(-256 -256)"></path>
                                                      </g>
                                                   </g>
                                                </svg>
                                                <!-- <span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span> Font Awesome fontawesome.com -->
                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="bg-body-emphasis">
                                       <div class="p-3 border-bottom border-translucent">
                                          <div class="d-flex justify-content-between">
                                             <div class="d-flex">
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-phone" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-phone"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-message" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-message"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg">
                                                   <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-video"></span> Font Awesome fontawesome.com -->
                                                </button>
                                             </div>
                                             <button class="btn btn-phoenix-primary">
                                                <svg class="svg-inline--fa fa-envelope me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com -->Send Email
                                             </button>
                                          </div>
                                       </div>
                                       <ul class="nav d-flex flex-column py-3 border-bottom">
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard me-2 text-body d-inline-block">
                                                   <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                   <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                </svg>
                                                <span class="text-body-highlight flex-1">Assigned Projects</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body">
                                                   <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                   <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                                </svg>
                                                <span class="text-body-highlight flex-1">View activiy</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Unassign </a></div>
                                 </div>
                                 <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <div class="avatar avatar-s  rounded-circle">
                                       <img class="rounded-circle " src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/59.webp" alt="">
                                    </div>
                                 </a>
                                 <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                    <div class="position-relative">
                                       <div class="bg-holder z-n1" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/bg/bg-32.png);background-size: auto;"></div>
                                       <!--/.bg-holder-->
                                       <div class="p-3">
                                          <div class="text-end">
                                             <button class="btn p-0 me-2">
                                                <svg class="svg-inline--fa fa-user-plus text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-user-plus text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn p-0">
                                                <svg class="svg-inline--fa fa-ellipsis text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-ellipsis text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                          <div class="text-center">
                                             <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/59.webp" alt=""></div>
                                             <h6 class="text-white">Katerina Karenin</h6>
                                             <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                             <div class="d-flex flex-center mb-3">
                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6>
                                                <svg class="svg-inline--fa fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.375em;">
                                                   <g transform="translate(256 256)">
                                                      <g transform="translate(0, -64)  scale(0.375, 0.375)  rotate(0 0 0)">
                                                         <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" transform="translate(-256 -256)"></path>
                                                      </g>
                                                   </g>
                                                </svg>
                                                <!-- <span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span> Font Awesome fontawesome.com -->
                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="bg-body-emphasis">
                                       <div class="p-3 border-bottom border-translucent">
                                          <div class="d-flex justify-content-between">
                                             <div class="d-flex">
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-phone" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-phone"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-message" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-message"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg">
                                                   <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-video"></span> Font Awesome fontawesome.com -->
                                                </button>
                                             </div>
                                             <button class="btn btn-phoenix-primary">
                                                <svg class="svg-inline--fa fa-envelope me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com -->Send Email
                                             </button>
                                          </div>
                                       </div>
                                       <ul class="nav d-flex flex-column py-3 border-bottom">
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard me-2 text-body d-inline-block">
                                                   <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                   <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                </svg>
                                                <span class="text-body-highlight flex-1">Assigned Projects</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body">
                                                   <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                   <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                                </svg>
                                                <span class="text-body-highlight flex-1">View activiy</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Unassign </a></div>
                                 </div>
                              </div>
                           </td>
                           <td class="align-middle white-space-nowrap start ps-3">
                              <p class="mb-0 fs-9 text-body">Sep 4, 2019</p>
                           </td>
                           <td class="align-middle white-space-nowrap deadline ps-3">
                              <p class="mb-0 fs-9 text-body">Dec 4, 2021</p>
                           </td>
                           <td class="align-middle white-space-nowrap calculation ps-3">
                              <p class="fw-bold text-body-emphasis fs-9 mb-0">$657k</p>
                              <p class="fw-semibold fs-10 text-body-tertiary mb-0">Estimation</p>
                           </td>
                           <td class="align-middle white-space-nowrap ps-3 projectprogress">
                              <p class="text-body-secondary fs-10 mb-0">277 / 539</p>
                              <div class="progress" style="height:3px;">
                                 <div class="progress-bar bg-success" style="width: 51.39146567717996%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" role="progressbar"></div>
                              </div>
                           </td>
                           <td class="align-middle white-space-nowrap ps-8">
                              <div class="progress progress-stack mt-3" style="height:3px;">
                                 <div class="progress-bar bg-info" style="width:10%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" role="progressbar" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Active" data-bs-original-title="Active"></div>
                                 <div class="progress-bar bg-danger" style="width:10%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" role="progressbar" aria-label="Damage" data-bs-original-title="Damage"></div>
                                 <div class="progress-bar bg-warning" style="width:35%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" role="progressbar" aria-label="Pending" data-bs-original-title="Pending"></div>
                                 <div class="progress-bar bg-success" style="width:45%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" role="progressbar" aria-label="Done" data-bs-original-title="Done"></div>
                              </div>
                           </td>
                           <td class="align-middle text-end white-space-nowrap pe-0 action">
                              <div class="btn-reveal-trigger position-static">
                                 <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                    <svg class="svg-inline--fa fa-ellipsis fs-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                       <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                    </svg>
                                    <!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com -->
                                 </button>
                                 <div class="dropdown-menu dropdown-menu-end py-2">
                                    <a class="dropdown-item" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">View</a><a class="dropdown-item" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Export</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Remove</a>
                                 </div>
                              </div>
                           </td>
                        </tr>
                        <tr class="position-static">
                           <td class="align-middle time white-space-nowrap ps-0 project"><a class="fw-bold fs-8" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#">Execution of Micky the foul mouse</a></td>
                           <td class="align-middle white-space-nowrap assignees ps-3">
                              <div class="avatar-group avatar-group-dense">
                                 <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <div class="avatar avatar-s  rounded-circle">
                                       <img class="rounded-circle " src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/1.webp" alt="">
                                    </div>
                                 </a>
                                 <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                    <div class="position-relative">
                                       <div class="bg-holder z-n1" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/bg/bg-32.png);background-size: auto;"></div>
                                       <!--/.bg-holder-->
                                       <div class="p-3">
                                          <div class="text-end">
                                             <button class="btn p-0 me-2">
                                                <svg class="svg-inline--fa fa-user-plus text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-user-plus text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn p-0">
                                                <svg class="svg-inline--fa fa-ellipsis text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-ellipsis text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                          <div class="text-center">
                                             <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/1.webp" alt=""></div>
                                             <h6 class="text-white">Luis Bunuel</h6>
                                             <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                             <div class="d-flex flex-center mb-3">
                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6>
                                                <svg class="svg-inline--fa fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.375em;">
                                                   <g transform="translate(256 256)">
                                                      <g transform="translate(0, -64)  scale(0.375, 0.375)  rotate(0 0 0)">
                                                         <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" transform="translate(-256 -256)"></path>
                                                      </g>
                                                   </g>
                                                </svg>
                                                <!-- <span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span> Font Awesome fontawesome.com -->
                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="bg-body-emphasis">
                                       <div class="p-3 border-bottom border-translucent">
                                          <div class="d-flex justify-content-between">
                                             <div class="d-flex">
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-phone" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-phone"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-message" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-message"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg">
                                                   <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-video"></span> Font Awesome fontawesome.com -->
                                                </button>
                                             </div>
                                             <button class="btn btn-phoenix-primary">
                                                <svg class="svg-inline--fa fa-envelope me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com -->Send Email
                                             </button>
                                          </div>
                                       </div>
                                       <ul class="nav d-flex flex-column py-3 border-bottom">
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard me-2 text-body d-inline-block">
                                                   <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                   <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                </svg>
                                                <span class="text-body-highlight flex-1">Assigned Projects</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body">
                                                   <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                   <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                                </svg>
                                                <span class="text-body-highlight flex-1">View activiy</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Unassign </a></div>
                                 </div>
                                 <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <div class="avatar avatar-s  rounded-circle">
                                       <img class="rounded-circle avatar-placeholder" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/avatar.webp" alt="">
                                    </div>
                                 </a>
                                 <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                    <div class="position-relative">
                                       <div class="bg-holder z-n1" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/bg/bg-32.png);background-size: auto;"></div>
                                       <!--/.bg-holder-->
                                       <div class="p-3">
                                          <div class="text-end">
                                             <button class="btn p-0 me-2">
                                                <svg class="svg-inline--fa fa-user-plus text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-user-plus text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn p-0">
                                                <svg class="svg-inline--fa fa-ellipsis text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-ellipsis text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                          <div class="text-center">
                                             <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/avatar.webp" alt=""></div>
                                             <h6 class="text-white">Kristine Cadena</h6>
                                             <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                             <div class="d-flex flex-center mb-3">
                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6>
                                                <svg class="svg-inline--fa fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.375em;">
                                                   <g transform="translate(256 256)">
                                                      <g transform="translate(0, -64)  scale(0.375, 0.375)  rotate(0 0 0)">
                                                         <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" transform="translate(-256 -256)"></path>
                                                      </g>
                                                   </g>
                                                </svg>
                                                <!-- <span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span> Font Awesome fontawesome.com -->
                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="bg-body-emphasis">
                                       <div class="p-3 border-bottom border-translucent">
                                          <div class="d-flex justify-content-between">
                                             <div class="d-flex">
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-phone" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-phone"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-message" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-message"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg">
                                                   <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-video"></span> Font Awesome fontawesome.com -->
                                                </button>
                                             </div>
                                             <button class="btn btn-phoenix-primary">
                                                <svg class="svg-inline--fa fa-envelope me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com -->Send Email
                                             </button>
                                          </div>
                                       </div>
                                       <ul class="nav d-flex flex-column py-3 border-bottom">
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard me-2 text-body d-inline-block">
                                                   <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                   <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                </svg>
                                                <span class="text-body-highlight flex-1">Assigned Projects</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body">
                                                   <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                   <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                                </svg>
                                                <span class="text-body-highlight flex-1">View activiy</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Unassign </a></div>
                                 </div>
                                 <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <div class="avatar avatar-s  rounded-circle">
                                       <img class="rounded-circle " src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/5.webp" alt="">
                                    </div>
                                 </a>
                                 <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                    <div class="position-relative">
                                       <div class="bg-holder z-n1" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/bg/bg-32.png);background-size: auto;"></div>
                                       <!--/.bg-holder-->
                                       <div class="p-3">
                                          <div class="text-end">
                                             <button class="btn p-0 me-2">
                                                <svg class="svg-inline--fa fa-user-plus text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-user-plus text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn p-0">
                                                <svg class="svg-inline--fa fa-ellipsis text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-ellipsis text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                          <div class="text-center">
                                             <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/5.webp" alt=""></div>
                                             <h6 class="text-white">Ricky Antony</h6>
                                             <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                             <div class="d-flex flex-center mb-3">
                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6>
                                                <svg class="svg-inline--fa fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.375em;">
                                                   <g transform="translate(256 256)">
                                                      <g transform="translate(0, -64)  scale(0.375, 0.375)  rotate(0 0 0)">
                                                         <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" transform="translate(-256 -256)"></path>
                                                      </g>
                                                   </g>
                                                </svg>
                                                <!-- <span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span> Font Awesome fontawesome.com -->
                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="bg-body-emphasis">
                                       <div class="p-3 border-bottom border-translucent">
                                          <div class="d-flex justify-content-between">
                                             <div class="d-flex">
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-phone" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-phone"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-message" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-message"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg">
                                                   <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-video"></span> Font Awesome fontawesome.com -->
                                                </button>
                                             </div>
                                             <button class="btn btn-phoenix-primary">
                                                <svg class="svg-inline--fa fa-envelope me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com -->Send Email
                                             </button>
                                          </div>
                                       </div>
                                       <ul class="nav d-flex flex-column py-3 border-bottom">
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard me-2 text-body d-inline-block">
                                                   <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                   <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                </svg>
                                                <span class="text-body-highlight flex-1">Assigned Projects</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body">
                                                   <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                   <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                                </svg>
                                                <span class="text-body-highlight flex-1">View activiy</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Unassign </a></div>
                                 </div>
                                 <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <div class="avatar avatar-s  rounded-circle">
                                       <img class="rounded-circle " src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/11.webp" alt="">
                                    </div>
                                 </a>
                                 <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                    <div class="position-relative">
                                       <div class="bg-holder z-n1" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/bg/bg-32.png);background-size: auto;"></div>
                                       <!--/.bg-holder-->
                                       <div class="p-3">
                                          <div class="text-end">
                                             <button class="btn p-0 me-2">
                                                <svg class="svg-inline--fa fa-user-plus text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-user-plus text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn p-0">
                                                <svg class="svg-inline--fa fa-ellipsis text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-ellipsis text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                          <div class="text-center">
                                             <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/11.webp" alt=""></div>
                                             <h6 class="text-white">Roy Anderson</h6>
                                             <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                             <div class="d-flex flex-center mb-3">
                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6>
                                                <svg class="svg-inline--fa fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.375em;">
                                                   <g transform="translate(256 256)">
                                                      <g transform="translate(0, -64)  scale(0.375, 0.375)  rotate(0 0 0)">
                                                         <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" transform="translate(-256 -256)"></path>
                                                      </g>
                                                   </g>
                                                </svg>
                                                <!-- <span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span> Font Awesome fontawesome.com -->
                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="bg-body-emphasis">
                                       <div class="p-3 border-bottom border-translucent">
                                          <div class="d-flex justify-content-between">
                                             <div class="d-flex">
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-phone" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-phone"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-message" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-message"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg">
                                                   <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-video"></span> Font Awesome fontawesome.com -->
                                                </button>
                                             </div>
                                             <button class="btn btn-phoenix-primary">
                                                <svg class="svg-inline--fa fa-envelope me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com -->Send Email
                                             </button>
                                          </div>
                                       </div>
                                       <ul class="nav d-flex flex-column py-3 border-bottom">
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard me-2 text-body d-inline-block">
                                                   <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                   <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                </svg>
                                                <span class="text-body-highlight flex-1">Assigned Projects</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body">
                                                   <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                   <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                                </svg>
                                                <span class="text-body-highlight flex-1">View activiy</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Unassign </a></div>
                                 </div>
                              </div>
                           </td>
                           <td class="align-middle white-space-nowrap start ps-3">
                              <p class="mb-0 fs-9 text-body">Nov 1, 2019</p>
                           </td>
                           <td class="align-middle white-space-nowrap deadline ps-3">
                              <p class="mb-0 fs-9 text-body">Dec 1, 2024</p>
                           </td>
                           <td class="align-middle white-space-nowrap calculation ps-3">
                              <button class="btn btn-phoenix-secondary btn-square-sm">
                                 <svg class="svg-inline--fa fa-plus" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"></path>
                                 </svg>
                                 <!-- <span class="fas fa-plus"></span> Font Awesome fontawesome.com -->
                              </button>
                           </td>
                           <td class="align-middle white-space-nowrap ps-3 projectprogress">
                              <p class="text-body-secondary fs-10 mb-0">16 / 56</p>
                              <div class="progress" style="height:3px;">
                                 <div class="progress-bar bg-success" style="width: 28.57142857142857%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" role="progressbar"></div>
                              </div>
                           </td>
                           <td class="align-middle white-space-nowrap ps-8">
                              <div class="progress progress-stack mt-3" style="height:3px;">
                                 <div class="progress-bar bg-info" style="width:45%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" role="progressbar" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Active" data-bs-original-title="Active"></div>
                                 <div class="progress-bar bg-danger" style="width:15%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" role="progressbar" aria-label="Damage" data-bs-original-title="Damage"></div>
                                 <div class="progress-bar bg-warning" style="width:20%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" role="progressbar" aria-label="Pending" data-bs-original-title="Pending"></div>
                                 <div class="progress-bar bg-success" style="width:20%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" role="progressbar" aria-label="Done" data-bs-original-title="Done"></div>
                              </div>
                           </td>
                           <td class="align-middle text-end white-space-nowrap pe-0 action">
                              <div class="btn-reveal-trigger position-static">
                                 <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                    <svg class="svg-inline--fa fa-ellipsis fs-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                       <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                    </svg>
                                    <!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com -->
                                 </button>
                                 <div class="dropdown-menu dropdown-menu-end py-2">
                                    <a class="dropdown-item" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">View</a><a class="dropdown-item" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Export</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Remove</a>
                                 </div>
                              </div>
                           </td>
                        </tr>
                        <tr class="position-static">
                           <td class="align-middle time white-space-nowrap ps-0 project"><a class="fw-bold fs-8" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#">Harnessing stupidity from Jerry</a></td>
                           <td class="align-middle white-space-nowrap assignees ps-3">
                              <div class="avatar-group avatar-group-dense">
                                 <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <div class="avatar avatar-s  rounded-circle">
                                       <img class="rounded-circle " src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/21.webp" alt="">
                                    </div>
                                 </a>
                                 <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                    <div class="position-relative">
                                       <div class="bg-holder z-n1" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/bg/bg-32.png);background-size: auto;"></div>
                                       <!--/.bg-holder-->
                                       <div class="p-3">
                                          <div class="text-end">
                                             <button class="btn p-0 me-2">
                                                <svg class="svg-inline--fa fa-user-plus text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-user-plus text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn p-0">
                                                <svg class="svg-inline--fa fa-ellipsis text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-ellipsis text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                          <div class="text-center">
                                             <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/21.webp" alt=""></div>
                                             <h6 class="text-white">Michael Jenkins</h6>
                                             <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                             <div class="d-flex flex-center mb-3">
                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6>
                                                <svg class="svg-inline--fa fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.375em;">
                                                   <g transform="translate(256 256)">
                                                      <g transform="translate(0, -64)  scale(0.375, 0.375)  rotate(0 0 0)">
                                                         <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" transform="translate(-256 -256)"></path>
                                                      </g>
                                                   </g>
                                                </svg>
                                                <!-- <span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span> Font Awesome fontawesome.com -->
                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="bg-body-emphasis">
                                       <div class="p-3 border-bottom border-translucent">
                                          <div class="d-flex justify-content-between">
                                             <div class="d-flex">
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-phone" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-phone"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-message" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-message"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg">
                                                   <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-video"></span> Font Awesome fontawesome.com -->
                                                </button>
                                             </div>
                                             <button class="btn btn-phoenix-primary">
                                                <svg class="svg-inline--fa fa-envelope me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com -->Send Email
                                             </button>
                                          </div>
                                       </div>
                                       <ul class="nav d-flex flex-column py-3 border-bottom">
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard me-2 text-body d-inline-block">
                                                   <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                   <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                </svg>
                                                <span class="text-body-highlight flex-1">Assigned Projects</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body">
                                                   <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                   <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                                </svg>
                                                <span class="text-body-highlight flex-1">View activiy</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Unassign </a></div>
                                 </div>
                                 <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <div class="avatar avatar-s  rounded-circle">
                                       <img class="rounded-circle " src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/23.webp" alt="">
                                    </div>
                                 </a>
                                 <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                    <div class="position-relative">
                                       <div class="bg-holder z-n1" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/bg/bg-32.png);background-size: auto;"></div>
                                       <!--/.bg-holder-->
                                       <div class="p-3">
                                          <div class="text-end">
                                             <button class="btn p-0 me-2">
                                                <svg class="svg-inline--fa fa-user-plus text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-user-plus text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn p-0">
                                                <svg class="svg-inline--fa fa-ellipsis text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-ellipsis text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                          <div class="text-center">
                                             <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/23.webp" alt=""></div>
                                             <h6 class="text-white">Kristine Cadena</h6>
                                             <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                             <div class="d-flex flex-center mb-3">
                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6>
                                                <svg class="svg-inline--fa fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.375em;">
                                                   <g transform="translate(256 256)">
                                                      <g transform="translate(0, -64)  scale(0.375, 0.375)  rotate(0 0 0)">
                                                         <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" transform="translate(-256 -256)"></path>
                                                      </g>
                                                   </g>
                                                </svg>
                                                <!-- <span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span> Font Awesome fontawesome.com -->
                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="bg-body-emphasis">
                                       <div class="p-3 border-bottom border-translucent">
                                          <div class="d-flex justify-content-between">
                                             <div class="d-flex">
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-phone" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-phone"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-message" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-message"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg">
                                                   <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-video"></span> Font Awesome fontawesome.com -->
                                                </button>
                                             </div>
                                             <button class="btn btn-phoenix-primary">
                                                <svg class="svg-inline--fa fa-envelope me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com -->Send Email
                                             </button>
                                          </div>
                                       </div>
                                       <ul class="nav d-flex flex-column py-3 border-bottom">
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard me-2 text-body d-inline-block">
                                                   <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                   <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                </svg>
                                                <span class="text-body-highlight flex-1">Assigned Projects</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body">
                                                   <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                   <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                                </svg>
                                                <span class="text-body-highlight flex-1">View activiy</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Unassign </a></div>
                                 </div>
                                 <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <div class="avatar avatar-s  rounded-circle">
                                       <img class="rounded-circle " src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/25.webp" alt="">
                                    </div>
                                 </a>
                                 <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                    <div class="position-relative">
                                       <div class="bg-holder z-n1" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/bg/bg-32.png);background-size: auto;"></div>
                                       <!--/.bg-holder-->
                                       <div class="p-3">
                                          <div class="text-end">
                                             <button class="btn p-0 me-2">
                                                <svg class="svg-inline--fa fa-user-plus text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-user-plus text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn p-0">
                                                <svg class="svg-inline--fa fa-ellipsis text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-ellipsis text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                          <div class="text-center">
                                             <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/25.webp" alt=""></div>
                                             <h6 class="text-white">Ricky Antony</h6>
                                             <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                             <div class="d-flex flex-center mb-3">
                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6>
                                                <svg class="svg-inline--fa fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.375em;">
                                                   <g transform="translate(256 256)">
                                                      <g transform="translate(0, -64)  scale(0.375, 0.375)  rotate(0 0 0)">
                                                         <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" transform="translate(-256 -256)"></path>
                                                      </g>
                                                   </g>
                                                </svg>
                                                <!-- <span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span> Font Awesome fontawesome.com -->
                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="bg-body-emphasis">
                                       <div class="p-3 border-bottom border-translucent">
                                          <div class="d-flex justify-content-between">
                                             <div class="d-flex">
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-phone" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-phone"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-message" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-message"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg">
                                                   <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-video"></span> Font Awesome fontawesome.com -->
                                                </button>
                                             </div>
                                             <button class="btn btn-phoenix-primary">
                                                <svg class="svg-inline--fa fa-envelope me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com -->Send Email
                                             </button>
                                          </div>
                                       </div>
                                       <ul class="nav d-flex flex-column py-3 border-bottom">
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard me-2 text-body d-inline-block">
                                                   <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                   <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                </svg>
                                                <span class="text-body-highlight flex-1">Assigned Projects</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body">
                                                   <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                   <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                                </svg>
                                                <span class="text-body-highlight flex-1">View activiy</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Unassign </a></div>
                                 </div>
                              </div>
                           </td>
                           <td class="align-middle white-space-nowrap start ps-3">
                              <p class="mb-0 fs-9 text-body">Dec 28, 2019</p>
                           </td>
                           <td class="align-middle white-space-nowrap deadline ps-3">
                              <p class="mb-0 fs-9 text-body">Nov 28, 2021</p>
                           </td>
                           <td class="align-middle white-space-nowrap calculation ps-3">
                              <button class="btn btn-phoenix-secondary btn-square-sm">
                                 <svg class="svg-inline--fa fa-plus" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"></path>
                                 </svg>
                                 <!-- <span class="fas fa-plus"></span> Font Awesome fontawesome.com -->
                              </button>
                           </td>
                           <td class="align-middle white-space-nowrap ps-3 projectprogress">
                              <p class="text-body-secondary fs-10 mb-0">169 / 394</p>
                              <div class="progress" style="height:3px;">
                                 <div class="progress-bar bg-success" style="width: 42.89340101522843%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" role="progressbar"></div>
                              </div>
                           </td>
                           <td class="align-middle white-space-nowrap ps-8">
                              <div class="progress progress-stack mt-3" style="height:3px;">
                                 <div class="progress-bar bg-info" style="width:25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" role="progressbar" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Active" data-bs-original-title="Active"></div>
                                 <div class="progress-bar bg-danger" style="width:35%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" role="progressbar" aria-label="Damage" data-bs-original-title="Damage"></div>
                                 <div class="progress-bar bg-warning" style="width:20%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" role="progressbar" aria-label="Pending" data-bs-original-title="Pending"></div>
                                 <div class="progress-bar bg-success" style="width:15%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" role="progressbar" aria-label="Done" data-bs-original-title="Done"></div>
                              </div>
                           </td>
                           <td class="align-middle text-end white-space-nowrap pe-0 action">
                              <div class="btn-reveal-trigger position-static">
                                 <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                    <svg class="svg-inline--fa fa-ellipsis fs-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                       <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                    </svg>
                                    <!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com -->
                                 </button>
                                 <div class="dropdown-menu dropdown-menu-end py-2">
                                    <a class="dropdown-item" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">View</a><a class="dropdown-item" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Export</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Remove</a>
                                 </div>
                              </div>
                           </td>
                        </tr>
                        <tr class="position-static">
                           <td class="align-middle time white-space-nowrap ps-0 project"><a class="fw-bold fs-8" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#">Water resistant mosquito killer gun</a></td>
                           <td class="align-middle white-space-nowrap assignees ps-3">
                              <div class="avatar-group avatar-group-dense">
                                 <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <div class="avatar avatar-s  rounded-circle">
                                       <img class="rounded-circle " src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/40x40/30.webp" alt="">
                                    </div>
                                 </a>
                                 <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                    <div class="position-relative">
                                       <div class="bg-holder z-n1" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/bg/bg-32.png);background-size: auto;"></div>
                                       <!--/.bg-holder-->
                                       <div class="p-3">
                                          <div class="text-end">
                                             <button class="btn p-0 me-2">
                                                <svg class="svg-inline--fa fa-user-plus text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-user-plus text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn p-0">
                                                <svg class="svg-inline--fa fa-ellipsis text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-ellipsis text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                          <div class="text-center">
                                             <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/40x40/30.webp" alt=""></div>
                                             <h6 class="text-white">Stanly Drinkwater</h6>
                                             <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                             <div class="d-flex flex-center mb-3">
                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6>
                                                <svg class="svg-inline--fa fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.375em;">
                                                   <g transform="translate(256 256)">
                                                      <g transform="translate(0, -64)  scale(0.375, 0.375)  rotate(0 0 0)">
                                                         <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" transform="translate(-256 -256)"></path>
                                                      </g>
                                                   </g>
                                                </svg>
                                                <!-- <span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span> Font Awesome fontawesome.com -->
                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="bg-body-emphasis">
                                       <div class="p-3 border-bottom border-translucent">
                                          <div class="d-flex justify-content-between">
                                             <div class="d-flex">
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-phone" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-phone"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-message" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-message"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg">
                                                   <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-video"></span> Font Awesome fontawesome.com -->
                                                </button>
                                             </div>
                                             <button class="btn btn-phoenix-primary">
                                                <svg class="svg-inline--fa fa-envelope me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com -->Send Email
                                             </button>
                                          </div>
                                       </div>
                                       <ul class="nav d-flex flex-column py-3 border-bottom">
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard me-2 text-body d-inline-block">
                                                   <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                   <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                </svg>
                                                <span class="text-body-highlight flex-1">Assigned Projects</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body">
                                                   <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                   <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                                </svg>
                                                <span class="text-body-highlight flex-1">View activiy</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Unassign </a></div>
                                 </div>
                                 <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <div class="avatar avatar-s  rounded-circle">
                                       <img class="rounded-circle avatar-placeholder" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/avatar.webp" alt="">
                                    </div>
                                 </a>
                                 <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                    <div class="position-relative">
                                       <div class="bg-holder z-n1" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/bg/bg-32.png);background-size: auto;"></div>
                                       <!--/.bg-holder-->
                                       <div class="p-3">
                                          <div class="text-end">
                                             <button class="btn p-0 me-2">
                                                <svg class="svg-inline--fa fa-user-plus text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-user-plus text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn p-0">
                                                <svg class="svg-inline--fa fa-ellipsis text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-ellipsis text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                          <div class="text-center">
                                             <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/avatar.webp" alt=""></div>
                                             <h6 class="text-white">Kristine Cadena</h6>
                                             <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                             <div class="d-flex flex-center mb-3">
                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6>
                                                <svg class="svg-inline--fa fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.375em;">
                                                   <g transform="translate(256 256)">
                                                      <g transform="translate(0, -64)  scale(0.375, 0.375)  rotate(0 0 0)">
                                                         <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" transform="translate(-256 -256)"></path>
                                                      </g>
                                                   </g>
                                                </svg>
                                                <!-- <span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span> Font Awesome fontawesome.com -->
                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="bg-body-emphasis">
                                       <div class="p-3 border-bottom border-translucent">
                                          <div class="d-flex justify-content-between">
                                             <div class="d-flex">
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-phone" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-phone"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-message" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-message"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg">
                                                   <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-video"></span> Font Awesome fontawesome.com -->
                                                </button>
                                             </div>
                                             <button class="btn btn-phoenix-primary">
                                                <svg class="svg-inline--fa fa-envelope me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com -->Send Email
                                             </button>
                                          </div>
                                       </div>
                                       <ul class="nav d-flex flex-column py-3 border-bottom">
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard me-2 text-body d-inline-block">
                                                   <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                   <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                </svg>
                                                <span class="text-body-highlight flex-1">Assigned Projects</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body">
                                                   <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                   <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                                </svg>
                                                <span class="text-body-highlight flex-1">View activiy</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Unassign </a></div>
                                 </div>
                                 <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <div class="avatar avatar-s  rounded-circle">
                                       <img class="rounded-circle " src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/59.webp" alt="">
                                    </div>
                                 </a>
                                 <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                    <div class="position-relative">
                                       <div class="bg-holder z-n1" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/bg/bg-32.png);background-size: auto;"></div>
                                       <!--/.bg-holder-->
                                       <div class="p-3">
                                          <div class="text-end">
                                             <button class="btn p-0 me-2">
                                                <svg class="svg-inline--fa fa-user-plus text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-user-plus text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn p-0">
                                                <svg class="svg-inline--fa fa-ellipsis text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-ellipsis text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                          <div class="text-center">
                                             <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/59.webp" alt=""></div>
                                             <h6 class="text-white">Katerina Karenin</h6>
                                             <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                             <div class="d-flex flex-center mb-3">
                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6>
                                                <svg class="svg-inline--fa fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.375em;">
                                                   <g transform="translate(256 256)">
                                                      <g transform="translate(0, -64)  scale(0.375, 0.375)  rotate(0 0 0)">
                                                         <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" transform="translate(-256 -256)"></path>
                                                      </g>
                                                   </g>
                                                </svg>
                                                <!-- <span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span> Font Awesome fontawesome.com -->
                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="bg-body-emphasis">
                                       <div class="p-3 border-bottom border-translucent">
                                          <div class="d-flex justify-content-between">
                                             <div class="d-flex">
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-phone" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-phone"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-message" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-message"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg">
                                                   <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-video"></span> Font Awesome fontawesome.com -->
                                                </button>
                                             </div>
                                             <button class="btn btn-phoenix-primary">
                                                <svg class="svg-inline--fa fa-envelope me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com -->Send Email
                                             </button>
                                          </div>
                                       </div>
                                       <ul class="nav d-flex flex-column py-3 border-bottom">
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard me-2 text-body d-inline-block">
                                                   <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                   <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                </svg>
                                                <span class="text-body-highlight flex-1">Assigned Projects</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body">
                                                   <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                   <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                                </svg>
                                                <span class="text-body-highlight flex-1">View activiy</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Unassign </a></div>
                                 </div>
                                 <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <div class="avatar avatar-s  rounded-circle">
                                       <img class="rounded-circle " src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/31.webp" alt="">
                                    </div>
                                 </a>
                                 <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                    <div class="position-relative">
                                       <div class="bg-holder z-n1" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/bg/bg-32.png);background-size: auto;"></div>
                                       <!--/.bg-holder-->
                                       <div class="p-3">
                                          <div class="text-end">
                                             <button class="btn p-0 me-2">
                                                <svg class="svg-inline--fa fa-user-plus text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-user-plus text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn p-0">
                                                <svg class="svg-inline--fa fa-ellipsis text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-ellipsis text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                          <div class="text-center">
                                             <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="https://prium.github.io/phoenix/v1.22.0/assets/img/team/31.webp" alt=""></div>
                                             <h6 class="text-white">Martina scorcese</h6>
                                             <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                             <div class="d-flex flex-center mb-3">
                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6>
                                                <svg class="svg-inline--fa fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.375em;">
                                                   <g transform="translate(256 256)">
                                                      <g transform="translate(0, -64)  scale(0.375, 0.375)  rotate(0 0 0)">
                                                         <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" transform="translate(-256 -256)"></path>
                                                      </g>
                                                   </g>
                                                </svg>
                                                <!-- <span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span> Font Awesome fontawesome.com -->
                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="bg-body-emphasis">
                                       <div class="p-3 border-bottom border-translucent">
                                          <div class="d-flex justify-content-between">
                                             <div class="d-flex">
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-phone" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-phone"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-message" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-message"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg">
                                                   <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-video"></span> Font Awesome fontawesome.com -->
                                                </button>
                                             </div>
                                             <button class="btn btn-phoenix-primary">
                                                <svg class="svg-inline--fa fa-envelope me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com -->Send Email
                                             </button>
                                          </div>
                                       </div>
                                       <ul class="nav d-flex flex-column py-3 border-bottom">
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard me-2 text-body d-inline-block">
                                                   <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                   <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                </svg>
                                                <span class="text-body-highlight flex-1">Assigned Projects</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body">
                                                   <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                   <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                                </svg>
                                                <span class="text-body-highlight flex-1">View activiy</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Unassign </a></div>
                                 </div>
                                 <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <div class="avatar avatar-s">
                                       <div class="avatar-name rounded-circle"><span>R</span></div>
                                    </div>
                                 </a>
                                 <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                                    <div class="position-relative">
                                       <div class="bg-holder z-n1" style="background-image:url(https://prium.github.io/phoenix/v1.22.0/assets/img/bg/bg-32.png);background-size: auto;"></div>
                                       <!--/.bg-holder-->
                                       <div class="p-3">
                                          <div class="text-end">
                                             <button class="btn p-0 me-2">
                                                <svg class="svg-inline--fa fa-user-plus text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-user-plus text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                             <button class="btn p-0">
                                                <svg class="svg-inline--fa fa-ellipsis text-white" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-ellipsis text-white"></span> Font Awesome fontawesome.com -->
                                             </button>
                                          </div>
                                          <div class="text-center">
                                             <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2">
                                                <div class="avatar-name rounded-circle"><span>R</span></div>
                                             </div>
                                             <h6 class="text-white">Roy Anderson</h6>
                                             <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                                             <div class="d-flex flex-center mb-3">
                                                <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6>
                                                <svg class="svg-inline--fa fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.375em;">
                                                   <g transform="translate(256 256)">
                                                      <g transform="translate(0, -64)  scale(0.375, 0.375)  rotate(0 0 0)">
                                                         <path fill="currentColor" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" transform="translate(-256 -256)"></path>
                                                      </g>
                                                   </g>
                                                </svg>
                                                <!-- <span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span> Font Awesome fontawesome.com -->
                                                <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="bg-body-emphasis">
                                       <div class="p-3 border-bottom border-translucent">
                                          <div class="d-flex justify-content-between">
                                             <div class="d-flex">
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-phone" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-phone"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2">
                                                   <svg class="svg-inline--fa fa-message" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="message" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-message"></span> Font Awesome fontawesome.com -->
                                                </button>
                                                <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg">
                                                   <svg class="svg-inline--fa fa-video" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                      <path fill="currentColor" d="M0 128C0 92.7 28.7 64 64 64H320c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM559.1 99.8c10.4 5.6 16.9 16.4 16.9 28.2V384c0 11.8-6.5 22.6-16.9 28.2s-23 5-32.9-1.6l-96-64L416 337.1V320 192 174.9l14.2-9.5 96-64c9.8-6.5 22.4-7.2 32.9-1.6z"></path>
                                                   </svg>
                                                   <!-- <span class="fa-solid fa-video"></span> Font Awesome fontawesome.com -->
                                                </button>
                                             </div>
                                             <button class="btn btn-phoenix-primary">
                                                <svg class="svg-inline--fa fa-envelope me-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com -->Send Email
                                             </button>
                                          </div>
                                       </div>
                                       <ul class="nav d-flex flex-column py-3 border-bottom">
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard me-2 text-body d-inline-block">
                                                   <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                   <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                </svg>
                                                <span class="text-body-highlight flex-1">Assigned Projects</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                          <li class="nav-item">
                                             <a class="nav-link px-3 d-flex flex-between-center" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart me-2 text-body">
                                                   <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                   <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                                </svg>
                                                <span class="text-body-highlight flex-1">View activiy</span>
                                                <svg class="svg-inline--fa fa-chevron-right fs-11" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                                   <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                                                </svg>
                                                <!-- <span class="fa-solid fa-chevron-right fs-11"></span> Font Awesome fontawesome.com -->
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Unassign </a></div>
                                 </div>
                              </div>
                           </td>
                           <td class="align-middle white-space-nowrap start ps-3">
                              <p class="mb-0 fs-9 text-body">Feb 24, 2020</p>
                           </td>
                           <td class="align-middle white-space-nowrap deadline ps-3">
                              <p class="mb-0 fs-9 text-body">Nov 24, 2021</p>
                           </td>
                           <td class="align-middle white-space-nowrap calculation ps-3">
                              <p class="fw-bold text-body-emphasis fs-9 mb-0">$55k</p>
                              <p class="fw-semibold fs-10 text-body-tertiary mb-0">Budget</p>
                           </td>
                           <td class="align-middle white-space-nowrap ps-3 projectprogress">
                              <p class="text-body-secondary fs-10 mb-0">600 / 600</p>
                              <div class="progress" style="height:3px;">
                                 <div class="progress-bar bg-success" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" role="progressbar"></div>
                              </div>
                           </td>
                           <td class="align-middle white-space-nowrap ps-8">
                              <div class="progress progress-stack mt-3" style="height:3px;">
                                 <div class="progress-bar bg-info" style="width:24%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" role="progressbar" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Active" data-bs-original-title="Active"></div>
                                 <div class="progress-bar bg-danger" style="width:5%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" role="progressbar" aria-label="Damage" data-bs-original-title="Damage"></div>
                                 <div class="progress-bar bg-warning" style="width:35%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" role="progressbar" aria-label="Pending" data-bs-original-title="Pending"></div>
                                 <div class="progress-bar bg-success" style="width:35%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" role="progressbar" aria-label="Done" data-bs-original-title="Done"></div>
                              </div>
                           </td>
                           <td class="align-middle text-end white-space-nowrap pe-0 action">
                              <div class="btn-reveal-trigger position-static">
                                 <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                    <svg class="svg-inline--fa fa-ellipsis fs-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                       <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                    </svg>
                                    <!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com -->
                                 </button>
                                 <div class="dropdown-menu dropdown-menu-end py-2">
                                    <a class="dropdown-item" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">View</a><a class="dropdown-item" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Export</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!">Remove</a>
                                 </div>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
               <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                  <div class="col-auto d-flex">
                     <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">1 to 6 <span class="text-body-tertiary"> Items of </span>6</p>
                     <a class="fw-semibold" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!" data-list-view="*">
                        View all
                        <svg class="svg-inline--fa fa-angle-right ms-1" data-fa-transform="down-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="" style="transform-origin: 0.3125em 0.5625em;">
                           <g transform="translate(160 256)">
                              <g transform="translate(0, 32)  scale(1, 1)  rotate(0 0 0)">
                                 <path fill="currentColor" d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z" transform="translate(-160 -256)"></path>
                              </g>
                           </g>
                        </svg>
                        <!-- <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span> Font Awesome fontawesome.com -->
                     </a>
                     <a class="fw-semibold d-none" href="https://prium.github.io/phoenix/v1.22.0/dashboard/project-management.html#!" data-list-view="less">
                        View Less
                        <svg class="svg-inline--fa fa-angle-right ms-1" data-fa-transform="down-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="" style="transform-origin: 0.3125em 0.5625em;">
                           <g transform="translate(160 256)">
                              <g transform="translate(0, 32)  scale(1, 1)  rotate(0 0 0)">
                                 <path fill="currentColor" d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z" transform="translate(-160 -256)"></path>
                              </g>
                           </g>
                        </svg>
                        <!-- <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span> Font Awesome fontawesome.com -->
                     </a>
                  </div>
                  <div class="col-auto d-flex">
                     <button class="page-link disabled" data-list-pagination="prev" disabled="">
                        <svg class="svg-inline--fa fa-chevron-left" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"></path>
                        </svg>
                        <!-- <span class="fas fa-chevron-left"></span> Font Awesome fontawesome.com -->
                     </button>
                     <ul class="mb-0 pagination">
                        <li class="active"><button class="page" type="button" data-i="1" data-page="6">1</button></li>
                     </ul>
                     <button class="page-link pe-0 disabled" data-list-pagination="next" disabled="">
                        <svg class="svg-inline--fa fa-chevron-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                           <path fill="currentColor" d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                        </svg>
                        <!-- <span class="fas fa-chevron-right"></span> Font Awesome fontawesome.com -->
                     </button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</main>
<!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->
<?php
get_footer();