<?php
/*
Template Name: Dashboard-Template
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div id="primary" <?php generate_do_element_classes( 'content' ); ?>>
		<main id="main" <?php generate_do_element_classes( 'main' ); ?>>

			<?php
			/**
			 * generate_before_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_before_main_content' );

			if ( generate_has_default_loop() ) {
				while ( have_posts() ) :

					the_post();
// Start Side Bar Nav
$return = '<div class="row gx-3 gx-lg-5 mt-0 ms-0 me-5">
  <div class="col-1 col-1 ms-0 ps-0">
    <ul class="nav nav-tabs nav-tabs-vertical py-4 m-0 bg-discovery-subtle" role="tablist">
      <li class="nav-item mt-7" role="presentation">
        <a class="nav-link active me-4" id="vertical-tab-0" data-bs-toggle="tab" href="#vertical-tabpanel-0" role="tab" aria-controls="vertical-tabpanel-0" aria-selected="true"><i class="fa fa-home" aria-hidden="true"></i></a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link me-4" id="vertical-tab-1" data-bs-toggle="tab" href="#vertical-tabpanel-1" role="tab" aria-controls="vertical-tabpanel-1" aria-selected="false"><i class="fa fa-table" aria-hidden="true"></i> All Learners</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link me-4" id="vertical-tab-agents" data-bs-toggle="tab" href="#vertical-tabpanel-agents" role="tab" aria-controls="vertical-tabpanel-agents" aria-selected="false"><i class="fa fa-table" aria-hidden="true"></i> All Agents</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link me-4" id="vertical-tab-classes" data-bs-toggle="tab" href="#vertical-tabpanel-classes" role="tab" aria-controls="vertical-tabpanel-classes" aria-selected="false"><i class="fa fa-table" aria-hidden="true"></i> All Classes</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link me-4" id="vertical-tab-2" data-bs-toggle="tab" href="#vertical-tabpanel-2" role="tab" aria-controls="vertical-tabpanel-2" aria-selected="false"><i class="fa fa-database" aria-hidden="true"></i> Custom SQL</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link me-4" id="vertical-tab-3" data-bs-toggle="tab" href="#vertical-tabpanel-3" role="tab" aria-controls="vertical-tabpanel-3" aria-selected="false"><i class="fa fa-line-chart" aria-hidden="true"></i> General Stats</a>
      </li>
      <li class="nav-item mt-7 border-top border-discovery border-2" role="presentation">
        <a class="nav-link me-4 mt-7" id="vertical-tab-4" data-bs-toggle="tab" href="#vertical-tabpanel-4" role="tab" aria-controls="vertical-tabpanel-4" aria-selected="false">New Learner</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link me-4" id="vertical-tab-5" data-bs-toggle="tab" href="#vertical-tabpanel-5" role="tab" aria-controls="vertical-tabpanel-5" aria-selected="false">New Agent</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link me-4" id="vertical-tab-6" data-bs-toggle="tab" href="#vertical-tabpanel-6" role="tab" aria-controls="vertical-tabpanel-6" aria-selected="false">New Class</a>
      </li>
    </ul>
  </div>
<div class="col-11">
<div class="tab-content" id="tab-content" aria-orientation="vertical">';

// Start Side Bar Nav
$return .= '<div class="tab-pane active" id="vertical-tabpanel-0" role="tabpanel" aria-labelledby="vertical-tab-0">
<div class="container mt-8 ms-0">
<div class="alert alert-primary" role="alert">
  <div class="d-flex gap-4">
    <span><i class="fa-solid fa-circle-info icon-primary"></i></span>
    <div class="d-flex flex-column gap-2">
      <h5 class="mb-0">Landing Page</h5>
      <p class="mb-0">You can add anything here that will make sense.</p>
    </div>
  </div>
</div>
</div>
<div class="container my-8 ms-0">
<div class="bd-intro"><div class="bd-bg-light px-4 px-md-6 px-lg-10 px-xl-20"><div class="row g-0"><div class="col-12 col-md-8 col-lg-6"><div class="py-4 py-md-6 py-lg-10 py-xl-20"><h1 class="mb-0">Tony Robbins</h1><p class="mt-3 text-body-secondary">"Every problem is a gift - without problems, we would not grow.”</p></div></div><div class="d-none d-md-block col-md-4 col-lg-6"><img class="w-100 h-auto max-w-sm" src="https://fastbootstrap.com/images/components@2x.png"></div></div></div></div>
</div>
<div class="container my-8 ms-0">
    <div class="row my-3">
        <div class="col">
            <h4>Charts</h4>
        </div>
    </div>
    <div class="row my-2">
        <div class="col-md-6 py-1">
            <div class="card">
                <div class="card-body">
                    <canvas id="chLine"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 py-1">
            <div class="card">
                <div class="card-body">
                    <canvas id="chBar"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container my-8 ms-0">
   <div class="row g-4">
      <div class="col-md-6">
         <div class="rounded bg-neutral-subtler">
            <div class="row g-0">
               <div class="col-5 col-md-4"><img class="w-100 h-auto" src="https://fastbootstrap.com/images/homepage-tokens@2x.png" alt="CSS Utilities"></div>
               <div class="col-7 col-md-8">
                  <div class="d-flex flex-column gap-2 ps-2 py-8 py-lg-12 pe-5">
                     <div class="d-flex align-items-center">
                        <span class="d-flex align-items-center justify-content-center rounded fw-semibold fs-xs bd-w-6 bd-h-6 bd-icon-yellow">U</span>
                        <h2 class="fs-5 mb-0 ms-2">CSS Utilities</h2>
                     </div>
                     <p class="mb-0 fs-sm">Utilities provide the building any design for layout or componsed that help us avoid writing custom styles, much simpler than Bootstrap.</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="rounded bg-neutral-subtler">
            <div class="row g-0">
               <div class="col-5 col-md-4"><img class="w-100 h-auto" src="https://fastbootstrap.com/images/homepage-components@2x.png" alt="Components"></div>
               <div class="col-7 col-md-8">
                  <div class="d-flex flex-column gap-2 ps-2 py-8 py-lg-12 pe-5">
                     <div class="d-flex align-items-center">
                        <span class="d-flex align-items-center justify-content-center rounded fw-semibold fs-xs bd-w-6 bd-h-6 bd-icon-green">C</span>
                        <h2 class="fs-5 mb-0 ms-2">Components</h2>
                     </div>
                     <p class="mb-0 fs-sm">Beautiful components that craft designed with Atlassian Design, make it easy to start for your next project. All components supports dark mode.</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="container my-8 ms-0">
   <div class="row g-4">
      <div class="col-3 mb-4">
         <a href="#" class="text-reset text-decoration-none">
            <div class="card bd-card max-w-sm border-0 h-100">
               <div class="card-body">
                  <div class="rounded bd-w-12 bd-h-12 mb-4 d-flex justify-content-center align-items-center bd-icon-green">B</div>
                  <h2 class="card-title h5 d-flex align-items-center">Button</h2>
                  <p class="text-body-tertiary fs-sm">Buttons allow users to perform an action or to navigate to another page, with a single tap.</p>
               </div>
            </div>
         </a>
      </div>


      <div class="col-3 mb-4">
         <a href="#" class="text-reset text-decoration-none">
            <div class="card bd-card max-w-sm border-0 h-100">
               <div class="card-body">
                  <div class="rounded bd-w-12 bd-h-12 mb-4 d-flex justify-content-center align-items-center bd-icon-green">B</div>
                  <h2 class="card-title h5 d-flex align-items-center">Button</h2>
                  <p class="text-body-tertiary fs-sm">Buttons allow users to perform an action or to navigate to another page, with a single tap.</p>
               </div>
            </div>
         </a>
      </div>
      <div class="col-3 mb-4">
         <a href="#" class="text-reset text-decoration-none">
            <div class="card bd-card max-w-sm border-0 h-100">
               <div class="card-body">
                  <div class="rounded bd-w-12 bd-h-12 mb-4 d-flex justify-content-center align-items-center bd-icon-green">B</div>
                  <h2 class="card-title h5 d-flex align-items-center">Button Group</h2>
                  <p class="text-body-tertiary fs-sm">Button group component is a grouping of buttons that gives users access to frequently performed, related actions.</p>
               </div>
            </div>
         </a>
      </div>
      <div class="col-3 mb-4">
         <a href="#" class="text-reset text-decoration-none">
            <div class="card bd-card max-w-sm border-0 h-100">
               <div class="card-body">
                  <div class="rounded bd-w-12 bd-h-12 mb-4 d-flex justify-content-center align-items-center bd-icon-green">C</div>
                  <h2 class="card-title h5 d-flex align-items-center">Close Button</h2>
                  <p class="text-body-tertiary fs-sm">A close button used for dismissing content like modals and alerts.</p>
               </div>
            </div>
         </a>
      </div>
   </div>
<div class="container my-8 ms-0">
   <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
      <div class="feature col">
         <h3 class="fs-2 text-body-emphasis">Featured title</h3>
         <p>Paragraph of text beneath the heading to explain the heading. Well add onto it with another sentence and probably just keep going until we run out of words.</p>
      </div>
      <div class="feature col">
         <h3 class="fs-2 text-body-emphasis">Featured title</h3>
         <p>Paragraph of text beneath the heading to explain the heading. Well add onto it with another sentence and probably just keep going until we run out of words.</p>
      </div>
      <div class="feature col">
         <h3 class="fs-2 text-body-emphasis">Featured title</h3>
         <p>Paragraph of text beneath the heading to explain the heading. Well add onto it with another sentence and probably just keep going until we run out of words.</p>
      </div>
   </div>
</div>
</div>';
$return .= '</div>';



// Start Display Learners
$return .= '<div class="tab-pane" id="vertical-tabpanel-1" role="tabpanel" aria-labelledby="vertical-tab-1">';
$return .= do_shortcode( '[wecoza_display_learners]' );
$return .= '</div>';
// Start Display Agents
$return .= '<div class="tab-pane" id="vertical-tabpanel-agents" role="tabpanel" aria-labelledby="vertical-tab-agents">';
$return .= do_shortcode( '[wecoza_display_agents]' );
$return .= '</div>';
// Start Dynamic Table
$return .= '<div class="tab-pane mt-6" id="vertical-tabpanel-2" role="tabpanel" aria-labelledby="vertical-tab-2">';
$return .= '<div class="alert alert-primary mt-4" role="alert">
  <div class="d-flex gap-4">
    <span><i class="fa-solid fa-circle-info icon-primary"></i></span>
    <div class="d-flex flex-column gap-2">
      <h6 class="mb-0">Custom Table Data</h6>
      <p class="mb-0">This table data was generated by the SQL generater below, then added to a custom form in the site admin area.</p>
    </div>
  </div>
</div>';
$return .= do_shortcode( '[wecoza_dynamic_table sql_id="10"]' );
$return .= '<div class="container mt-4 ms-0"><div class="row">
            <div class="col-6">

<div class="alert alert-discovery mb-4" role="alert">
  <div class="d-flex gap-4">
    <span><i class="fa-solid fa-circle-question icon-discovery"></i></span>
    <div class="d-flex flex-column gap-2">
      <h6 class="mb-0">SQL Generator</h6>
      <p class="mb-0">Clearly convey the data you aim to extract from the database.</p>
    </div>
  </div>
</div>
   <!-- <gradio-app src="https://laudes-ai-eee-sql-gen.hf.space"></gradio-app> -->
</div>
         </div></div>';
$return .= '</div>';
// Start General Stats
$return .= '<div class="tab-pane" id="vertical-tabpanel-3" role="tabpanel" aria-labelledby="vertical-tab-3">';
if (!is_user_logged_in()) {
   $return .= '<div class="container my-8 ms-0"><div class="row"><div class="col-6"><section class="alert alert-warning my-5" role="alert"><div class="d-flex gap-4"><span><i class="fa-solid fa-circle-exclamation icon-warning fa-lg"></i></span><div>You must be logged in as <code>Admin</code> to view this data.</div></div></section></div></div></div>';
}
$return .= '</div>';
// Start Capture a learner
$return .= '<div class="tab-pane mt-6" id="vertical-tabpanel-4" role="tabpanel" aria-labelledby="vertical-tab-4">';
$return .= '<div class="container my-4 ms-0">
<div class="alert alert-discovery" role="alert"><div class="d-flex gap-4"><span><i class="fa-solid fa-circle-question icon-discovery"></i></span><div class="d-flex flex-column gap-2"><h5 class="mb-0">Capture a New Learner</h5><p class="mb-0">Before you start the upload process ensure you have valid documents.</p></div></div></div>
</div>';
$return .= '<div class="container container-md learners-form ms-0">';
$return .= do_shortcode( '[wecoza_learners_form]' );
$return .= '</div>';
$return .= '</div>';

// Start Capture of Agent
$return .= '<div class="tab-pane mt-6" id="vertical-tabpanel-5" role="tabpanel" aria-labelledby="vertical-tab-5">';
$return .= '<div class="container my-4 ms-0">
<div class="alert alert-discovery" role="alert"><div class="d-flex gap-4"><span><i class="fa-solid fa-circle-question icon-discovery"></i></span><div class="d-flex flex-column gap-2"><h5 class="mb-0">Capture a New Agent</h5><p class="mb-0">Before you start the upload process ensure you have valid documents.</p></div></div></div>
</div>';
$return .= '<div class="container container-md learners-form ms-0">';
$return .= do_shortcode( '[wecoza_capture_agents]' );
$return .= '</div>';
$return .= '</div>';

// Start Capture of Class
$return .= '<div class="tab-pane mt-6" id="vertical-tabpanel-6" role="tabpanel" aria-labelledby="vertical-tab-6">';
$return .= '<div class="container my-4 ms-0">
<div class="alert alert-discovery" role="alert"><div class="d-flex gap-4"><span><i class="fa-solid fa-circle-question icon-discovery"></i></span><div class="d-flex flex-column gap-2"><h5 class="mb-0">Create a new Class</h5><p class="mb-0">Before you start the upload process ensure you have all info. ready.</p></div></div></div>
</div>';
$return .= '<div class="container container-md learners-form ms-0">';
$return .= do_shortcode( '[wecoza_capture_class]' );
$return .= '</div>';
$return .= '</div>';

$return .= '</div>
  </div>
</div>';

print $return;

				endwhile;
			} ?>

<?php
			/**
			 * generate_after_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_after_main_content' );
			?>
		</main>
	</div>

	<?php
	/**
	 * generate_after_primary_content_area hook.
	 *
	 * @since 2.0
	 */
	do_action( 'generate_after_primary_content_area' );

	generate_construct_sidebars();

	get_footer();