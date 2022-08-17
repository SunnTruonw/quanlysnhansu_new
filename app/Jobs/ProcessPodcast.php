<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 4;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($podcast)
    {
        //
        $this->podcast = $podcast;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            // thực hiện cuộc gọi api


        } catch (\Throwable $exception) {
            if ($this->attempts() > 3) {
                // thất bại khó sau 3 lần thử
                throw $exception;
            }

            // xếp hàng lại công việc này để được thực hiện
            // sau 3 phút (180 giây) kể từ bây giờ
            $this->release(180);
            return;
        }
    }

    public function retryUntil()
    {
        // sẽ tiếp tục thử lại, theo logic dự phòng bên dưới
        // cho đến 12 giờ kể từ lần chạy đầu tiên.
        // Sau đó, nếu nó không thành công, nó sẽ đi
        // tới bảng fail_jobs
        return now()->addHours(12);
    }

    /**
     * Tính số giây phải chờ trước khi thử lại công việc.
     *
     * @return array
     */
    public function backoff()
    {
        // 5 lần thử lại đầu tiên, sau lần thử đầu tiên thất bại
        // sẽ cách nhau 5 phút (300 giây),
        // những nỗ lực tiếp theo sẽ được
        // 3 giờ (10.800 giây) sau
        // lần thử trước
        return [300, 300, 300, 300, 300, 10800];
    }
}
