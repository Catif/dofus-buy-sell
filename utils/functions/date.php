<?php

function now()
{
  return date('Y-m-d H:i:s');
}

function today()
{
  return date('Y-m-d');
}

function diff(string|DateTime $date1, string|DateTime|null $date2 = null)
{
  if (is_string($date1)) {
    $date1 = new DateTime($date1);
  }

  if (is_string($date2)) {
    $date2 = new DateTime($date2);
  } else if ($date2 === null) {
    $date2 = new DateTime();
  }

  $diff = $date1->diff($date2);

  return $diff;
}

function diffHuman(string|DateTime $date1, string|DateTime|null $date2 = null)
{
  $diff = diff($date1, $date2);

  $diffString = '';

  if ($diff->y > 0) {
    $diffString .= $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ';
  }

  if ($diff->m > 0) {
    $diffString .= $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ';
  }

  if ($diff->d > 0) {
    $diffString .= $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ';
  }

  if ($diff->h > 0) {
    $diffString .= $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ';
  }

  if ($diff->i > 0) {
    $diffString .= $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ';
  }

  if ($diff->s > 0) {
    $diffString .= $diff->s . ' second' . ($diff->s > 1 ? 's' : '') . ' ';
  }

  if ($diffString === '') {
    $diffString = '0 second';
  }

  return $diffString;
}
