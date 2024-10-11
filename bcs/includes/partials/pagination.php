<?php
/**
 * Generates HTML for pagination.
 *
 * @param WP_Query $query WP_Query object.
 * @param int $paged Current page.
 */
function render_pagination ($query, $paged)
{
  $total_pages = $query->max_num_pages;
  $current_page = $paged;

  if ($total_pages <= 1) {
    return; // There is no need to display pagination if there is only one page
  }

  // Calculation of previous and next pages
  $prev_page = max (1, $current_page - 1);
  $next_page = min ($total_pages, $current_page + 1);

  echo '<div class="pagination-wrapper"><div class="pagination"><ul>';

  // "Previous" button
  if ($current_page > 1) {
    echo '<li class="pagination__item prev" data-target-page="' . esc_attr ($prev_page) . '"><div class="pagination__link">Previous <i class="arrow_pag"></i></div></li>';
  }

  // Always show the first page
  echo '<li class="pagination__item ' . ($current_page == 1 ? 'active' : '') . '" data-target-page="1"><div class="pagination__link">1</div></li>';

  // Display "..." if the current page is more than 4
  if ($current_page > 4) {
    echo '<li><span>...</span></li>';
  }

  // Displaying pages around the current one
  for ($count = max (2, $current_page - 2); $count <= min ($current_page + 2, $total_pages - 1); $count++) {
    if ($count == 1 || $count == $total_pages) {
      continue; // The first and last pages are already displayed
    }

    if ($count == $current_page) {
      echo '<li class="pagination__item active" data-target-page="' . esc_attr ($count) . '"><div class="pagination__link">' . esc_html ($count) . '</div></li>';
    } else {
      echo '<li class="pagination__item" data-target-page="' . esc_attr ($count) . '"><div class="pagination__link">' . esc_html ($count) . '</div></li>';
    }
  }

  // Display "..." if current page is less than $total_pages - 3
  if ($current_page < $total_pages - 3) {
    echo '<li><span>...</span></li>';
  }

  // Always show last page if more than 1
  if ($total_pages > 1) {
    echo '<li class="pagination__item ' . ($current_page == $total_pages ? 'active' : '') . '" data-target-page="' . esc_attr($total_pages) . '"><div class="pagination__link">' . esc_html($total_pages) . '</div></li>';
  }

  // Next button
  if ($current_page < $total_pages) {
    echo '<li class="pagination__item next" data-target-page="' . esc_attr ($next_page) . '"><div class="pagination__link">Next <i class="arrow_pag"></i></div></li>';
  }

  echo '</ul></div></div>';
}

?>
