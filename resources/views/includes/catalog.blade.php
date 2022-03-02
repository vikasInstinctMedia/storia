<div class="col-md-3 col-md-pull-9">
  <div class="sidebar">
    {{-- 
    <div class="widget widget-product-categories">
      <h3 class="widget-title">Product Categories</h3>
      <ul class="product-categories">

        @forelse($categories as $category)
          <li><a href="{{ route('front.category', $category->slug) }}">{{ $category->name }}</a> <span class="count">{{ $category->products_count }}</span></li>
        @empty
          <li></li>
        @endforelse
      </ul>
    </div>
    --}}
    <!-- <div class="widget widget_price_filter">
                    <h3 class="widget-title">Filter by price</h3>
                    <div class="price_slider_wrapper">
                      <div class="price_slider" style="display:none;"></div>
                      <div class="price_slider_amount">
                        <input type="text" id="min_price" name="min_price" value="" data-min="0" placeholder="Min price"/>
                        <input type="text" id="max_price" name="max_price" value="" data-max="150" placeholder="Max price"/>
                        <button type="submit" class="button">Filter</button>
                        <div class="price_label" style="display:none;">
                          Price: <span class="from"></span> &mdash; <span class="to"></span>
                        </div>
                        <div class="clear"></div>
                      </div>
                    </div>
                  </div> -->
    <div class="widget widget-products">
      <h3 class="widget-title">Popular Products</h3>
      <ul class="product-list-widget">

        @forelse($trending_products as $product)
        <li>
          <a href="{{ route('front.category',  $product->slug ) }}">
            <img src="{{ asset('storage/'.$product->banner_image) }}" alt="" />
            <span class="product-title">{{ $product->name }}</span>
          </a>
          @if($product->base_pack_price_without_discount > 0)
          <del>₹{{ $product->base_pack_price_without_discount }}</del>
          @endif
          <ins>₹{{ $product->base_pack_price }}</ins>
        </li>

        @empty
          no data 
        @endforelse
      </ul>
    </div>
  </div>
</div>