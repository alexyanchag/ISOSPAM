@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header"><h3 class="card-title">Relación Longitud–Peso (L–W)</h3></div>
  <div class="card-body">
    
<canvas id="lw"></canvas>
@push('scripts')
<script>
const pts = {!! json_encode($pairs) !!}.map(p=>({x: parseFloat(p.L), y: parseFloat(p.W)})).filter(p=>!isNaN(p.x)&&!isNaN(p.y));
// Ajuste rápido y=b*L^a en log10: logW = logb + a*logL
const xs = pts.map(p=>Math.log(p.x)), ys = pts.map(p=>Math.log(p.y));
function linreg(x,y){
  const n=x.length, sx=x.reduce((a,b)=>a+b,0), sy=y.reduce((a,b)=>a+b,0);
  const sxx=x.reduce((a,b)=>a+b*b,0), sxy=x.map((v,i)=>v*y[i]).reduce((a,b)=>a+b,0);
  const a=(n*sxy - sx*sy)/(n*sxx - sx*sx), b=(sy - a*sx)/n; // log-space
  const r2 = (()=>{
    const yhat=x.map(v=>a*v+b), sst=y.reduce((s,yi)=>s+(yi - sy/n)**2,0), ssr=y.reduce((s,yi,i)=>s+(yi - yhat[i])**2,0);
    return 1-ssr/sst;
  })();
  return {a, b, r2};
}
let res = {a:0,b:0,r2:0};
if(xs.length>5){ res = linreg(xs,ys); }
const a = res.a, b = Math.exp(res.b), r2 = res.r2;

new Chart(document.getElementById('lw'), {
  type:'scatter',
  data:{ datasets:[{ label:'Datos', data: pts }] },
});
// mostramos parámetros en consola
console.log('a=',a.toFixed(3),' b=',b.toExponential(3),' R2=',r2.toFixed(3));
</script>
@endpush

  </div>
</div>
@endsection
