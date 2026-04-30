<?php
$pageTitle = 'Coding Examples | Jonathan Connell';
$currentPage = 'coding-examples';
$basePath = '../';

require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>

<main class="content">
    <section class="inner-page">
        <div class="inner-page__content">
            <h1>Coding Examples</h1>

            <h2>PHP & MySQL News Feed</h2>

            <p>
                This example from my HTML & CSS assessment uses PHP with PDO to retrieve
                news articles from a MySQL database and render them dynamically. It also
                escapes output to protect the page from unsafe content.
            </p>

            <pre class="code-example"><code>&lt;?php
require_once __DIR__ . '/database.php';

$stmt = $pdo-&gt;query("
    SELECT id, type, image, title, description, button, author_image, author, date
    FROM news
");

$newsItems = $stmt-&gt;fetchAll();
?&gt;

&lt;div class="news-grid"&gt;
    &lt;?php foreach ($newsItems as $item): ?&gt;
        &lt;?php $isCareer = $item['type'] === 'Careers'; ?&gt;

        &lt;a href="#" class="news-card &lt;?= $isCareer ? 'news-card__career' : '' ?&gt;"&gt;
            &lt;div class="news-card__media"&gt;
                &lt;img
                    src="&lt;?= htmlspecialchars('img/' . $item['image']) ?&gt;"
                    alt="&lt;?= htmlspecialchars($item['title']) ?&gt;"
                &gt;

                &lt;span class="news-card__tag &lt;?= $isCareer ? 'news-card__tag--career' : '' ?&gt;"&gt;
                    &lt;?= htmlspecialchars($item['type']) ?&gt;
                &lt;/span&gt;
            &lt;/div&gt;

            &lt;div class="news-card__content"&gt;
                &lt;h2&gt;&lt;?= htmlspecialchars($item['title']) ?&gt;&lt;/h2&gt;

                &lt;p&gt;&lt;?= htmlspecialchars($item['description']) ?&gt;&lt;/p&gt;

                &lt;div class="news-card__meta"&gt;
                    &lt;img
                        class="news-card__avatar"
                        src="&lt;?= htmlspecialchars('img/' . $item['author_image']) ?&gt;"
                        alt="&lt;?= htmlspecialchars($item['author']) ?&gt;"
                    &gt;

                    &lt;div&gt;
                        &lt;strong&gt;Posted by &lt;?= htmlspecialchars($item['author']) ?&gt;&lt;/strong&gt;
                        &lt;span&gt;
                            &lt;?= date('jS F Y', strtotime($item['date'])) ?&gt;
                        &lt;/span&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        &lt;/a&gt;
    &lt;?php endforeach; ?&gt;
&lt;/div&gt;</code></pre>
        </div>
    </section>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>