@include ('layout.subscribe')

<section class="footer-widget">
<?php
   dynamic_sidebar('footer')
?>
</section>

<footer class="level is-mobile">
    @if(have_rows('social_links', 'option'))
        <div class="level-left">
            @while(have_rows('social_links', 'option'))
                <?php the_row(); ?>
                    <a target="_newtab" href="{{ the_sub_field('url') }}" class="social">
                        <span class="icon is-medium"><i class="fa fa-{{ the_sub_field('icon') }}"></i></span>
                    </a>
            @endwhile
        </div>
    @endif
    <div class="level-right copyright">
        HEID & SEEK © {{ date('Y') }}
    </div>
</footer>
