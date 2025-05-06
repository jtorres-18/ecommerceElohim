// js/reportes.js

// Único wrapper para amCharts
am5.ready(function() {

  // 1) Función que crea el gráfico de ventas por día
  function crearGraficoVentas(ventas) {
    // Root & tema
    var root = am5.Root.new("ventas_semana");
    root.setThemes([ am5themes_Animated.new(root) ]);

    // XYChart
    var chart = root.container.children.push(
      am5xy.XYChart.new(root, {
        panX: true, panY: true, wheelX: "none", wheelY: "none"
      })
    );
    chart.zoomOutButton.set("forceHidden", true);

    // Ejes
    var xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });
    xRenderer.labels.template.setAll({
      rotation: -90, centerY: am5.p50, centerX: 0, paddingRight: 15
    });
    xRenderer.grid.template.set("visible", false);

    var xAxis = chart.xAxes.push(
      am5xy.CategoryAxis.new(root, {
        categoryField: "dia", renderer: xRenderer, maxDeviation: 0.3
      })
    );
    var yAxis = chart.yAxes.push(
      am5xy.ValueAxis.new(root, {
        renderer: am5xy.AxisRendererY.new(root, {}), maxDeviation: 0.3, min: 0
      })
    );

    // Series de columnas
    var series = chart.series.push(
      am5xy.ColumnSeries.new(root, {
        name: "Ventas",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "value",
        categoryXField: "dia"
      })
    );
    series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5, strokeOpacity: 0 });
    series.columns.template.adapters.add("fill", function(fill, target) {
      return chart.get("colors").getIndex(series.columns.indexOf(target));
    });
    series.columns.template.adapters.add("stroke", function(stroke, target) {
      return chart.get("colors").getIndex(series.columns.indexOf(target));
    });

    series.bullets.push(function() {
      return am5.Bullet.new(root, {
        locationY: 1,
        sprite: am5.Label.new(root, {
          text: "{valueYWorking.formatNumber('#.')}",
          fill: root.interfaceColors.get("alternativeText"),
          centerY: 0, centerX: am5.p50, populateText: true
        })
      });
    });

    // Mapear datos recibidos
    var data = ventas.map(function(v) {
      return { dia: v.dia, value: parseFloat(v.total_vendido_dia) };
    });
    xAxis.data.setAll(data);
    series.data.setAll(data);

    // Animaciones de entrada
    series.appear(1000);
    chart.appear(1000, 100);
  }

  // 2) Función que crea el gráfico de top productos
  function crearGraficoProductos(productos) {
    var root = am5.Root.new("mas_vendido");
    root.setThemes([ am5themes_Animated.new(root) ]);

    var chart = root.container.children.push(
      am5percent.PieChart.new(root, {
        radius: am5.percent(90),
        innerRadius: am5.percent(50),
        layout: root.horizontalLayout
      })
    );

    var series = chart.series.push(
      am5percent.PieSeries.new(root, {
        name: "Productos",
        valueField: "sales",
        categoryField: "producto"
      })
    );

    var data = productos.slice(0, 5).map(function(p) {
      return { producto: p.nameProd, sales: parseFloat(p.total_vendido) };
    });
    series.data.setAll(data);

    series.labels.template.set("visible", false);
    series.ticks.template.set("visible", false);
    series.slices.template.setAll({
      strokeOpacity: 0,
      fillGradient: am5.RadialGradient.new(root, {
        stops: [
          { brighten: -0.8 }, { brighten: -0.8 },
          { brighten: -0.5 }, { brighten: 0 },
          { brighten: -0.5 }
        ]
      })
    });

    var legend = chart.children.push(
      am5.Legend.new(root, {
        centerY: am5.percent(50),
        y: am5.percent(50),
        layout: root.verticalLayout
      })
    );
    legend.valueLabels.template.setAll({ textAlign: "right" });
    legend.labels.template.setAll({ maxWidth: 140, width: 140, oversizedBehavior: "wrap" });
    legend.data.setAll(series.dataItems);

    series.appear(1000, 100);
  }

  // 3) AJAX para obtener ventas y dibujar gráfico
  $.ajax({
    type: "POST",
    url: "procesar_reportes.php",
    data: { reporte: "ventas" },
    dataType: "json",
    success: crearGraficoVentas,
    error: function(xhr, status, error) {
      console.error("Error al cargar ventas:", error, xhr.responseText);
    }
  });

  // 4) AJAX para obtener productos y dibujar gráfico
  $.ajax({
    type: "POST",
    url: "procesar_reportes.php",
    data: { reporte: "producto" },
    dataType: "json",
    success: crearGraficoProductos,
    error: function(xhr, status, error) {
      console.error("Error al cargar productos:", error, xhr.responseText);
    }
  });

}); // end am5.ready()




