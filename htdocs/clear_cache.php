<?php

/**
 * @param $projectPath
 * @throws Exception
 */
function clear_cache($projectPath)
{
    $cachePath = '../cache/';
    $packagesJson = $cachePath . 'packages.json';
    if ($projectPath) {
        $projectComposerFile = $cachePath . $projectPath . '.json';
        if (file_exists($projectComposerFile)) {
            if ((unlink($projectComposerFile) && unlink($packagesJson)) === false) {
                throw new \Exception('Cache could not be flushed');
            } else {
                echo "cleared cache for $projectComposerFile";
            }
        } else {
            echo 'project composer file not found';
        }
    } else {
        echo 'project '.print_r($_POST['project'],true)." not found";
    }
}

/**
 * @throws Exception
 */
function run()
{
    $gitlabToken = "qgtdNfbP46H4FpporVqCViRMiK";
    $headers = getallheaders();

    if (strcmp($headers['X-Gitlab-Token'], $gitlabToken) === 0) {
        $requestBody = json_decode(file_get_contents('php://input'), true);
        $pathWithNamespace = $requestBody['project']['path_with_namespace'];
        clear_cache($pathWithNamespace);
    } else {
        header("HTTP/1.1 401 Unauthorized");
    }
}

try {
    run();
} catch (\Exception $e) {
    header("HTTP/1.1 500 " . $e->getMessage());
}

