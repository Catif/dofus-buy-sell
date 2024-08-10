<?php

function isHTTP(): bool
{
  return isset($_SERVER['HTTP_HOST']);
}

function success(string $message): void
{
  if (isHTTP()) {
    header('Content-Type: application/json');
    echo json_encode(['success' => $message]);
  } else {
    echo "\033[32m" . $message . "\033[0m\n";
  }
}

function error(string $message): void
{
  if (isHTTP()) {
    http_response_code(500);
    echo json_encode(['error' => $message]);
  } else {
    echo "\033[31m" . $message . "\033[0m\n";
  }
}

function info(string $message): void
{
  if (isHTTP()) {
    echo json_encode(['info' => $message]);
  } else {
    echo $message . "\n";
  }
}

function warning(string $message): void
{
  if (isHTTP()) {
    echo json_encode(['warning' => $message]);
  } else {
    echo "\033[33m" . $message . "\033[0m\n";
  }
}

function timer(int $duration, ?callable $formatMessage): void
{
  for ($i = $duration; $i >= 0; $i--) {
    if ($formatMessage) {
      echo "\r" . $formatMessage($i);
    } else {
      echo "\r" . $i . "s remaining...";
    }

    sleep(1);
  }
  echo "\n";
}

function spaces(int $number = 1): void
{
  $spaces = str_repeat("\n", $number);

  echo $spaces;
}

function clearTerminal(): void
{
  $system = php_uname('s');

  if ($system === 'Linux') {
    system('clear');
  } else {
    system('cls');
  }
}
