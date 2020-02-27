<div>
  <div class="col" style="direction: rtl;">
    <div class="row text-right">
      <p class="details col-lg-3 col-sm-6 my-2">
        تعداد کل خانوارها:
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        <?php getAllMembersCount(); ?>
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        تعداد کل خانوارهای فعال:
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        <?php getAllActiveMembersCount(); ?>
      </p>
    </div>
    <div class="row">
      <p class="details col-lg-3 col-sm-6 my-2">
        تعداد خانوارهای VIP فعال:
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        <?php getVipActiveMembersCount(); ?>
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        تعداد خانوار‌های VIP (کل):
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        <?php getAllVipMembersCount(); ?>
      </p>
    </div>
    <div class="row">
      <p class="details col-lg-3 col-sm-6 my-2">
        تعداد خانوارهای عادی فعال:
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        <?php getNormalActiveMembersCount(); ?>
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        تعداد خانوارهای عادی (کل):
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        <?php getAllNormalMembersCount(); ?>
      </p>
    </div>
  </div>
</div>