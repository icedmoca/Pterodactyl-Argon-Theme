// Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com>0
//
// Permission is hereby granted, free of charge, to any person obtaining a copy
// of this software and associated documentation files (the "Software"), to deal
// in the Software without restriction, including without limitation the rights
// to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the Software is
// furnished to do so, subject to the following conditions:
//
// The above copyright notice and this permission notice shall be included in all
// copies or substantial portions of the Software.
//
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
// OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
// SOFTWARE.
$(document).ready(function () {

    Socket.on('proc', function (proc) {
      updateStats(proc);
    });

    Socket.on('status', function (data) {
      if(data.status < 1 || data.status > 3){
        clearStats();
      }
    });

    Socket.on('initial status', function (data) {
      if(data.status < 1 || data.status > 3){
        clearStats();
      }
    });

    var initialCpuDetail = $('#server_cpu_icon').attr("data-original-title");
    var initialMemoryDetail = $('#server_memory_icon').attr("data-original-title");
    var initialDiskDetail = $('#server_disk_icon').attr("data-original-title");

    function updateStats(proc){
      var cpuUse = (Pterodactyl.server.cpu > 0) ? parseFloat(((proc.data.cpu.total / Pterodactyl.server.cpu) * 100).toFixed(3).toString()) : proc.data.cpu.total;
      var cpuDetail = Math.round(cpuUse) + "%";

      var memoryTotal = parseFloat((proc.data.memory.total / (1024 * 1024)).toFixed(3).toString());
      var memoryMax = parseFloat((proc.data.memory.amax / (1000 * 1000)).toFixed(3).toString());



      if(proc.data.memory.amax > 0){
        var memoryUse = parseFloat(((memoryTotal / memoryMax) * 100).toFixed(3).toString());
        var memoryDetail = Math.round(memoryTotal) + " / " + Math.round(memoryMax) + " MB";
      }
      else{
        var memoryUse = memoryTotal;
        var memoryDetail = Math.round(memoryTotal) + " / ∞ MB";
      }

      if(proc.data.disk.limit > 0){
        var diskUse = parseFloat(((proc.data.disk.used / proc.data.disk.limit) * 100).toFixed(3).toString());
        var diskDetail = Math.round(proc.data.disk.used) + " / " + proc.data.disk.limit + " MB";
      }
      else{
        var diskUse = proc.data.disk.used;
        var diskDetail = Math.round(proc.data.disk.used) + " / ∞ MB";
      }

      $('#server_stats_cpu').html(Math.round(cpuUse));
      updateCpuDetail(cpuDetail);

      $('#server_stats_memory').html(Math.round(memoryUse));
      updateMemoryDetail(memoryDetail);

      $('#server_stats_disk').html(Math.round(diskUse));
      updateDiskDetail(diskDetail);
    }

    function clearStats(){
      $('#server_stats_cpu').html('0');
      $('#server_stats_memory').html('0');
      $('#server_stats_disk').html('0');
      updateCpuDetail(initialCpuDetail);
      updateMemoryDetail(initialCpuDetail);
      updateDiskDetail(initialCpuDetail);
    }

    function updateCpuDetail(content){
      if($('#server_cpu_icon').attr("data-original-title") != content){
        $('#server_cpu_icon').html('<div class="icon icon-shape bg-yellow text-white rounded-circle shadow"><i class="fas fa-microchip"></i></div>');
        $('#server_cpu_icon').attr("data-original-title", content).tooltip('hide');
      }
    }

    function updateMemoryDetail(content){
      if($('#server_memory_icon').attr("data-original-title") != content){
        $('#server_memory_icon').html('<div class="icon icon-shape bg-warning text-white rounded-circle shadow"><i class="fas fa-memory"></i></div>');
        $('#server_memory_icon').attr("data-original-title", content).tooltip('hide');
      }
    }

    function updateDiskDetail(content){
      if($('#server_disk_icon').attr("data-original-title") != content){
        $('#server_disk_icon').html('<div class="icon icon-shape bg-info text-white rounded-circle shadow"><i class="fas fa-hdd"></i></div>');
        $('#server_disk_icon').attr("data-original-title", content).tooltip('hide');
      }
    }

});
