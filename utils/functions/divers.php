<?php

function env($key, $default = null)
{
  $data = getenv($key, true);

  return $data !== false ? $data : $default;
}

function config($key)
{
  [$file, $key] = explode('.', $key);

  try {
    $config = require ROOT . '/utils/config/' . $file . '.php';
  } catch (Exception $e) {
    error('The file ' . $file . '.php does not exist.');
    die();
  }

  return isset($config[$key]) ? $config[$key] : null;
}

function generateEnv($env_files_path)
{
  $elementsEnv = [];
  $fopen = fopen($env_files_path, 'r');

  if (!$fopen) {
    error("The file .env does not exist.");
    die();
  }

  while (($line = fgets($fopen)) !== false) {
    $line_is_comment = (substr(trim($line), 0, 1) == '#') ? true : false;
    if ($line_is_comment || empty(trim($line)))
      continue;

    $line_no_comment = explode("#", $line, 2)[0];

    $env_ex = preg_split('/(\s?)\=(\s?)/', $line_no_comment);
    $env_name = trim($env_ex[0]);
    $env_value = isset($env_ex[1]) ? trim($env_ex[1]) : "";
    $elementsEnv[$env_name] = $env_value;
  }

  fclose($fopen);

  foreach ($elementsEnv as $key => $value) {
    if (!getenv($key)) {
      putenv("$key=$value");
    }
  }

  return $elementsEnv;
}
