<?php
declare(strict_types = 1);

use SiteApi\Core\UUID;

include __DIR__ . '/../vendor/autoload.php';

define('TEMP_DIR', __DIR__ . '/../etc/cache');

switch ($argv[1] ?? '') {
    case 'insert-articles':
        $data = [];
        $row = 1;

        try {
            $csvFile = fopen(TEMP_DIR . '/sampleData.csv', 'r');

            if ($csvFile) {
                while ($line = fgets($csvFile)) {
                    list($url, $title) = explode(',', $line);
                    echo "$row - fetching url: $url\n";

                    $parsedContent = parseArticle($url);

                    echo "Inserting article: $title\n";
                    saveArticle($title, $parsedContent['content'], $parsedContent['author']);

                    $parsedContent['title'] = $title;
                    $data[] = $parsedContent;
                    $row++;
                }
            }
            fclose($csvFile);
            file_put_contents(TEMP_DIR . '/articles.json', json_encode($data));
        } catch (Throwable $exception) {
        }
        break;
    case 'create-csv':
        createSampleDataCSV();
        break;
    default:
        echo "Invalid Argument.\n";
}

function createSampleDataCSV()
{
    $html = file_get_contents('https://www.i-programmer.info/news/98-languages.html');
    $html = str_replace(["\n", "  ", "\t"], '', $html);
    $html = str_replace(' >', '>', $html);

    $pattern = '|<tr class="sectiontableentry[1-2]">.*<a href="(.*)">(.*)</a>.*</tr>|U';
    preg_match_all($pattern, $html, $links, PREG_SET_ORDER);

    $csvContent = '';
    foreach ($links as $link) {
        $csvContent .= "https://www.i-programmer.info$link[1],$link[2]\n";
    }

    file_put_contents(TEMP_DIR . '/sampleData.csv', $csvContent);
}

function parseArticle($url)
{
    $html = file_get_contents($url);
    $html = str_replace(['&nbsp;', 'Written by'], ' ', $html);
    $html = str_replace(['More Information', 'Related Articles'], '__RENAMED__', $html);

    $pattern = [
        'author' => '|class="contentpaneopen">.*class="small">(.*)</span>.*</table>|Usi',
        'date' => '|class="contentpaneopen">.*class="createdate">(.*)</td>.*</table>|Usi',
        'content' => '|class="contentpaneopen">.*id="IprogrammerMainArticleTextBody"[^>]*>(.*)<[^>]*>\s*__RENAMED__\s*</.*</table>|Usi',
    ];

    $result = [];
    foreach ($pattern as $key => $patternItem) {
        preg_match_all($patternItem, $html, $article, PREG_SET_ORDER);
        $result[$key] = trim($article[0][1] ?? '');
    }

    return $result;
}

function saveArticle($title, $text, $author)
{
    $pdo = new PDO('mysql:host=127.0.0.1;port=9906;dbname=web_db', 'devuser', 'devpass');

    $statement = $pdo->prepare('
        INSERT INTO articles (article_id, title, text, author)
        VALUES (:id, :title, :text, :author)
    ');

    $statement->execute([
        ':id' => UUID::create(),
        ':title' => $title,
        ':text' => $text,
        ':author' => $author,
    ]);
}
