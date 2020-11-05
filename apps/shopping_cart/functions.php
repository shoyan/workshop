<?php
function generateCsrfToken() {
  return hash('sha256', session_id());
} 
