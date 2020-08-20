<script>
      var divDougnhut = document.getElementById('financement-doughnut');
      var margin = {top: 10, right: 10, bottom: 10, left: 10};

      const widthDoughnut = 500 - margin.left - margin.right,
          heightDoughnut = 450 - margin.top - margin.bottom,
          maxRadius = (Math.min(widthDoughnut, heightDoughnut) / 2) - 5;

      const formatNumber = d3.format(',d');

      const x = d3.scaleLinear()
          .range([0, 2 * Math.PI])
          .clamp(true);

      const y = d3.scaleSqrt()
          .range([maxRadius*.1, maxRadius]);

      const color = d3.scaleOrdinal(colors);

      const partition = d3.partition();

      const arc = d3.arc()
          .startAngle(d => x(d.x0))
          .endAngle(d => x(d.x1))
          .innerRadius(d => Math.max(0, y(d.y0)))
          .outerRadius(d => Math.max(0, y(d.y1)));

      const middleArcLine = d => {
          const halfPi = Math.PI/2;
          const angles = [x(d.x0) - halfPi, x(d.x1) - halfPi];
          const r = Math.max(0, (y(d.y0) + y(d.y1)) / 2);

          const middleAngle = (angles[1] + angles[0]) / 2;
          const invertDirection = middleAngle > 0 && middleAngle < Math.PI; // On lower quadrants write text ccw
          if (invertDirection) { angles.reverse(); }

          const path = d3.path();
          path.arc(0, 0, r, angles[0], angles[1], invertDirection);
          return path.toString();
      };


      const textFits = d => {
          const CHAR_SPACE = 6;

          const deltaAngle = x(d.x1) - x(d.x0);
          const r = Math.max(0, (y(d.y0) + y(d.y1)) / 2);
          const perimeter = r * deltaAngle;

          return d.data.name.length * CHAR_SPACE < perimeter;
      };

      const svgDoughnut = d3.select('#financement-doughnut').append('svg')
          .style('width', '18%')
          .style('height', '50%')
          .attr('viewBox', `${-width / 2} ${-height / 2} ${width} ${height}`)
          .on('click', () => focusOn()); // Reset zoom on canvas click

      d3.json("/getJsonD3Doughnut/{{ $place->slug }}", (error, root) => {
          if (error) throw error;
          root = d3.hierarchy(root);
          root.sum(d => d.size);

          const slice = svgDoughnut.selectAll('g.slice')
              .data(partition(root).descendants());

          slice.exit().remove();

          const newSlice = slice.enter()
              .append('g').attr('class', 'slice')
              .on('click', d => {
                  d3.event.stopPropagation();
                  focusOn(d);
              });

          newSlice.append('title')
              .text(function(d){ d.data.name + '\n' + formatNumber(d.data.value)});

          newSlice.append('path')
              .attr('class', 'main-arc')
              .style('fill', function(d){
                let col = color((d.children ? d : d.parent).data.name);
                return col;
              })
              .attr('d', arc);

          newSlice.append('path')
              .attr('class', 'hidden-arc')
              .attr('id', (_, i) => `hiddenArc${i}`)
              .attr('d', middleArcLine);

          const text = newSlice.append('text')
              .attr('display', d => textFits(d) ? null : 'none');

          // Add white contour
          text.append('textPath')
              .attr('startOffset','50%')
              .attr('xlink:href', (_, i) => `#hiddenArc${i}` )
              .text(d => d.data.name)
              .style('fill', 'none');

          text.append('textPath')
              .attr('startOffset','50%')
              .attr('xlink:href', (_, i) => `#hiddenArc${i}` )
              .text(d => d.data.name + ': ' + d.value + '€');
      });

      function focusOn(d = { x0: 0, x1: 1, y0: 0, y1: 1 }) {
          // Reset to top-level if no data point specified

          const transition = svgDoughnut.transition()
              .duration(750)
              .tween('scale', () => {
                  const xd = d3.interpolate(x.domain(), [d.x0, d.x1]),
                      yd = d3.interpolate(y.domain(), [d.y0, 1]);
                  return t => { x.domain(xd(t)); y.domain(yd(t)); };
              });

          transition.selectAll('path.main-arc')
              .attrTween('d', d => () => arc(d));

          transition.selectAll('path.hidden-arc')
              .attrTween('d', d => () => middleArcLine(d));

          transition.selectAll('text')
              .attrTween('display', d => () => textFits(d) ? null : 'none');

          moveStackToFront(d);


          function moveStackToFront(elD) {
              svgDoughnut.selectAll('.slice').filter(d => d === elD)
                  .each(function(d) {
                      this.parentNode.appendChild(this);
                      if (d.parent) { moveStackToFront(d.parent); }
                  })
          }
      }
</script>