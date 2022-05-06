<?php declare(strict_types=1);

namespace Shopware\Storefront\Framework\Captcha;

use GuzzleHttp\ClientInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Shopware\Core\Framework\Feature;
use Symfony\Component\HttpFoundation\Request;

class GoogleReCaptchaV3 extends AbstractCaptcha
{
    public const CAPTCHA_NAME = 'googleReCaptchaV3';
    public const CAPTCHA_REQUEST_PARAMETER = '_grecaptcha_v3';
    private const GOOGLE_CAPTCHA_VERIFY_ENDPOINT = 'https://www.google.com/recaptcha/api/siteverify';
    private const DEFAULT_THRESHOLD_SCORE = 0.5;

    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function isValid(Request $request /* , array $captchaConfig */): bool
    {
        if (\func_num_args() < 2 || !\is_array(func_get_arg(1))) {
            Feature::triggerDeprecationOrThrow(
                'v6.5.0.0',
                'Method `isValid()` in `GoogleReCaptchaV3` expects passing the `$captchaConfig` as array as the second parameter in v6.5.0.0.'
            );
        }

        if (!$request->get(self::CAPTCHA_REQUEST_PARAMETER)) {
            return false;
        }

        $captchaConfig = \func_get_args()[1] ?? [];

        $secretKey = !empty($captchaConfig['config']['secretKey']) ? $captchaConfig['config']['secretKey'] : null;

        if (!\is_string($secretKey) || $secretKey === '') {
            return false;
        }

        try {
            $response = $this->client->request('POST', self::GOOGLE_CAPTCHA_VERIFY_ENDPOINT, [
                'form_params' => [
                    'secret' => $secretKey,
                    'response' => $request->get(self::CAPTCHA_REQUEST_PARAMETER),
                    'remoteip' => $request->getClientIp(),
                ],
            ]);

            $responseRaw = $response->getBody()->getContents();
            $response = json_decode($responseRaw, true);

            $thresholdScore = !empty($captchaConfig['config']['thresholdScore']) ? (float) $captchaConfig['config']['thresholdScore'] : self::DEFAULT_THRESHOLD_SCORE;

            return $response && (bool) $response['success'] && (float) $response['score'] >= $thresholdScore;
        } catch (ClientExceptionInterface $exception) {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return self::CAPTCHA_NAME;
    }
}
