<?php

// File generated from our OpenAPI spec

namespace Payske\Service;

class FileService extends \Payske\Service\AbstractService
{
    /**
     * Returns a list of the files that your account has access to. The files are
     * returned sorted by creation date, with the most recently created files appearing
     * first.
     *
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Collection
     */
    public function all($params = null, $opts = null)
    {
        return $this->requestCollection('get', '/api/v1/files', $params, $opts);
    }

    /**
     * Retrieves the details of an existing file object. Supply the unique file ID from
     * a file, and Payske will return the corresponding file object. To access file
     * contents, see the <a href="/docs/file-upload#download-file-contents">File Upload
     * Guide</a>.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\File
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->buildPath('/api/v1/files/%s', $id), $params, $opts);
    }

    /**
     * Create a file.
     *
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @return \Payske\File
     */
    public function create($params = null, $opts = null)
    {
        $opts = \Payske\Util\RequestOptions::parse($opts);
        if (!isset($opts->apiBase)) {
            $opts->apiBase = $this->getClient()->getFilesBase();
        }

        // Manually flatten params, otherwise curl's multipart encoder will
        // choke on nested null|arrays.
        $flatParams = \array_column(\Payske\Util\Util::flattenParams($params), 1, 0);

        return $this->request('post', '/api/v1/files', $flatParams, $opts);
    }
}
