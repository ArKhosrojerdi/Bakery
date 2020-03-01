<div class="col">
  <label for="show-stats"> نمایش تعداد خانوارها و افراد در سامانه
    <input type="checkbox" onchange="showStats();" name="show-stats" id="show-stats">
  </label>
</div>

<div id="customers-stats" hidden>
  <div class="col" style="direction: rtl;">
    <div class="row bg-light">
      <p class="details col-lg-3 col-sm-6 my-2">
        تعداد خانوارها (کل):
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        <?php getAllFamiliesCount(); ?>
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        تعداد کل خانوارهای فعال:
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        <?php getAllActiveFamiliesCount(); ?>
      </p>
    </div>
    <div class="row">
      <p class="details col-lg-3 col-sm-6 my-2">
        تعداد خانوار‌های VIP (کل):
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        <?php getAllVipFamiliesCount(); ?>
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        تعداد خانوارهای VIP فعال:
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        <?php getVipActiveFamiliesCount(); ?>
      </p>
    </div>
    <div class="row bg-light">
      <p class="details col-lg-3 col-sm-6 my-2">
        تعداد خانوارهای عادی (کل):
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        <?php getAllNormalFamiliesCount(); ?>
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        تعداد خانوارهای عادی فعال:
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        <?php getNormalActiveFamiliesCount(); ?>
      </p>
    </div>
    <div class="row">
      <p class="details col-lg-3 col-sm-6 my-2">
        تعداد افراد (کل):
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        <?php getAllMembersCount(); ?>
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        تعداد کل افراد فعال:
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        <?php getAllActiveMembersCount(); ?>
      </p>
    </div>
    <div class="row bg-light">
      <p class="details col-lg-3 col-sm-6 my-2">
        تعداد افراد VIP (کل):
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        <?php getAllVipMembersCount(); ?>
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        تعداد افراد VIP فعال:
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        <?php getVipActiveMembersCount(); ?>
      </p>
    </div>
    <div class="row">
      <p class="details col-lg-3 col-sm-6 my-2">
        تعداد افراد عادی (کل):
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        <?php getAllNormalMembersCount(); ?>
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        تعداد افراد عادی فعال:
      </p>
      <p class="details col-lg-3 col-sm-6 my-2">
        <?php getNormalActiveMembersCount(); ?>
      </p>
    </div>
  </div>
</div>

<script>
    function showStats() {
        document.getElementById("customers-stats").hidden = !document.getElementById("show-stats").checked;
    }
</script>