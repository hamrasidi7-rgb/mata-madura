{{--
    x-category-card: kartu kategori (rounded, border halus, shadow lembut, putih di atas cream).
    Props: $category (App\Models\Category)
--}}
@props(['category'])

<a href="{{ route('category.show', $category) }}"
   class="flex items-center justify-between px-4 py-3.5 rounded-xl border border-hair bg-white
          text-[14px] font-semibold text-[#2a2620] shadow-soft
          hover:border-accent hover:text-accent transition">
    {{ $category->name }}
    <x-icon name="chevron" class="w-3.5 h-3.5" />
</a>
