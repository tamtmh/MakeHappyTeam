<?php if ($pageCount > 1) : ?>
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-end">
        <?php 
        echo $this->Paginator->prev(
            'Previous', 
            array('tag' => 'li', 'escape' => false, 'class' => 'page-item page-link disabled'), 
            '<a href="#" class="page-link-disabled" tabindex="-1 " aria-disabled="true">Previous</a>'
        );
        
        echo $this->Paginator->numbers(
            array(
                'separator' => '',
                'tag' => 'li',
                'class' => 'page-item page-link',
                'currentLink' => true, 
                'currentClass' => 'active',
                'currentTag' => 'a',
                'modulus' => 5
            )
        ); 
        echo $this->Paginator->next(
            'Next',
            array('tag' => 'li', 'escape' => false, 'class' => 'page-item page-link'),
            '<a href="#" class="page-link-disabled">Next</a>'
        );
        ?>
    </ul>
</nav>
<?php endif; ?>