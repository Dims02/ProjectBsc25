<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>  
<?php require_once __DIR__ . '/../partials/banner.php'; ?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8" >
    <div class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-xl font-semibold text-gray-900">Our Mission</h2>
      <p class="mt-2 text-gray-600">
        This project is part of a BSc Cybersecurity initiative at <strong>Universidade da Beira Interior (UBI)</strong>. 
        With the growing importance of cybersecurity compliance, our goal is to develop a survey platform that helps 
        organizations assess their adherence to cybersecurity regulations, such as the <strong>NIS2 Directive</strong> and <strong>GDPR</strong>.
      </p>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mt-6">
      <h2 class="text-xl font-semibold text-gray-900">Project Overview</h2>
      <p class="mt-2 text-gray-600">
      This platform empowers organizations to thoroughly evaluate their compliance levels by administering <strong>detailed surveys</strong>. These surveys are designed not only to collect data but also to generate <strong>comprehensive reports and analytics</strong> that offer a clear picture of an organization's current compliance status. Moreover, the platform provides <strong>specific recommendations</strong> to address any areas where compliance standards are not being met, enabling organizations to implement targeted improvements. This holistic approach supports <strong>continuous monitoring</strong> and <strong>proactive management</strong> of compliance, ensuring that any deviations from the required standards are identified and remedied in a timely manner.
      </p>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mt-6">
      <h2 class="text-xl font-semibold text-gray-900">Key Features</h2>
      <ul class="list-disc list-inside mt-2 text-gray-600">
        <li>Intuitive survey creation and management</li>
        <li>Guided compliance recommendations</li>
        <li>Data export options (PDF, JSON)</li>
        <li>Responsive and user-friendly design</li>
      </ul>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mt-6">
      <h2 class="text-xl font-semibold text-gray-900">Technology Stack</h2>
      <p class="mt-2 text-gray-600">
        The platform is developed using <strong>PHP, HTML5, CSS3, MySQL, and JavaScript</strong> and leverages <strong>TailwindCSS</strong> for a modern, responsive design. It adheres to industry best practices by utilizing <strong>Git-based version control</strong> to streamline development and ensure robust code management. Furthermore, the entire solution is hosted on <strong>Okeanos</strong>, providing a reliable and scalable environment that meets both performance and security standards.
      </p>

    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mt-6">
      <h2 class="text-xl font-semibold text-gray-900">Supervision & University</h2>
      <p class="mt-2 text-gray-600">
        This project is supervised by <strong>Professor Pedro Inácio</strong> 
        (<a href="mailto:inacio@di.ubi.pt" class="text-indigo-600 hover:underline">inacio@di.ubi.pt</a>) 
        and developed at <strong>Universidade da Beira Interior (UBI)</strong> by <strong> Diogo Silva </strong>(<a href="mailto:matos.silva@di.ubi.pt" class="text-indigo-600 hover:underline">matos.silva@di.ubi.pt</a>).
      </p>
    </div>

    <div class="mt-8 text-center pb-6" >
      <a href="/surveys" class="<?= $highlightColor; ?> px-5 py-2 rounded-md text-lg hover:bg-opacity-80">
        Explore Surveys
      </a>
    </div>
  </div>
</main >

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
