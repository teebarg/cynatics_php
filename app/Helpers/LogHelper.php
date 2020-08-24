<?php

namespace App\Helpers;

use App\Mail\ExceptionMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;

/**
 * LogHelper assists in writing log messages to file and sending emails.
 *
 * @author Oyelaking
 */
class LogHelper
{

    /**
     * Log the error to the log file and send an error message.
     *
     * @param string $message
     * @param mixed ...$contextData
     */
    public static function error(string $message, ...$contextData)
    {
        Log::error($message, $contextData);
        self::sendErrorMail($message, $contextData);
    }

    /**
     * Called when an exception occurs
     *
     * @param \Exception $ex
     * @param array $extraContext
     */
    public static function exception(\Exception $ex, $extraContext = [])
    {
        self::sendExceptionMail($ex, $extraContext);
    }

    /**
     * Logs the error to file only and does not send mail.
     *
     * @param string $message
     * @param mixed ...$contextData
     */
    public static function errorLog(string $message, ...$contextData)
    {
        Log::error($message, $contextData);
    }

    /**
     * Log the info to file.
     *
     * @param string $message
     * @param mixed ...$contextData
     */
    public static function info(string $message, ...$contextData)
    {
        Log::info($message, $contextData);
    }

    /**
     * Send error mail.
     *
     * @param string $errorMessage
     * @param type $contextData
     * @return type
     */
    public static function sendErrorMail(string $errorMessage, ...$contextData)
    {
        //send error mail if it's not local
        if (env('APP_ENV') == 'local') {
            return;
        }
        try {
            $e = FlattenException::create($contextData);

            $handler = new SymfonyExceptionHandler();

            $html = $handler->getHtml($e);

            Mail::to('neyostica2000@yahoo.com')->send(new ExceptionMail($html));

        } catch (\Exception $ex) {
            Log::error($ex->getMessage(), [
                "message" => "Error occurred while trying to send error "
                . "mail for error: " . $errorMessage,
                "initialContextData" => $contextData,
                "exception" => $ex
            ]);
        }
    }

    public static function sendExceptionMail(\Throwable $e, $context = [])
    {
        //send error mail if it's not local
        if (env('APP_ENV') == 'local') {
            return;
        }
        try {
            $e = FlattenException::create($context);

            $handler = new SymfonyExceptionHandler();

            $html = $handler->getHtml($e);

            Mail::to('neyostica2000@yahoo.com')->send(new ExceptionMail($html));

        } catch (\Exception $ex) {
            self::error($ex->getMessage(), [
                "message" => "Error occurred while trying to send exception "
                . "mail for exception with message: " . $e->getMessage()
            ]);
        }
    }

}
