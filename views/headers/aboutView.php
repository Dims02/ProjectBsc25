<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>  
<?php require_once __DIR__ . '/../partials/banner.php'; ?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
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
        The platform enables organizations to create, manage, and analyze security compliance surveys efficiently. 
        It includes an <strong>administration panel</strong>, <strong>custom survey creation</strong>, 
        <strong>recommendation-based responses</strong>, and <strong>data analytics features</strong>.
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
        The platform is built using <strong>PHP, HTML5, CSS3, MySQL</strong>, and utilizes <strong>TailwindCSS</strong> for styling. 
        It follows best practices in software engineering, including <strong>Git-based version control</strong>.
      </p>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mt-6">
      <h2 class="text-xl font-semibold text-gray-900">Supervision & University</h2>
      <p class="mt-2 text-gray-600">
        This project is supervised by <strong>Professor Pedro Inácio</strong> 
        (<a href="mailto:inacio@di.ubi.pt" class="text-indigo-600 hover:underline">inacio@di.ubi.pt</a>) 
        and developed at <strong>Universidade da Beira Interior (UBI)</strong>.
      </p>
    </div>

    <div class="mt-8 text-center">
      <a href="/surveys" class="<?= $highlightColor; ?> px-5 py-2 rounded-md text-lg hover:bg-opacity-80">
        Explore Surveys
      </a>
    </div>
  </div>
</main>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
