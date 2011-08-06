<?php

namespace Club\MessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\MessageBundle\Repository\MessageAttachment")
 * @ORM\Table(name="club_message_message_attachment")
 * @ORM\HasLifecycleCallbacks()
 */
class MessageAttachment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @Assert\File(maxSize="6000000")
     *
     * @var string $file
     */
    public $file;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $file_path
     */
    private $file_path;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $file_name
     */
    private $file_name;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $file_type
     */
    private $file_type;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $file_size
     */
    private $file_size;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $file_hash
     */
    private $file_hash;

    /**
     * @ORM\ManyToOne(targetEntity="Message")
     *
     * @var Club\MessageBundle\Entity\Message
     */
    private $message;


    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set file_path
     *
     * @param string $filePath
     */
    public function setFilePath($filePath)
    {
        $this->file_path = $filePath;
    }

    /**
     * Get file_path
     *
     * @return string $filePath
     */
    public function getFilePath()
    {
        return $this->file_path;
    }

    /**
     * Set file_name
     *
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->file_name = $fileName;
    }

    /**
     * Get file_name
     *
     * @return string $fileName
     */
    public function getFileName()
    {
        return $this->file_name;
    }

    /**
     * Set file_type
     *
     * @param string $fileType
     */
    public function setFileType($fileType)
    {
        $this->file_type = $fileType;
    }

    /**
     * Get file_type
     *
     * @return string $fileType
     */
    public function getFileType()
    {
        return $this->file_type;
    }

    /**
     * Set file_size
     *
     * @param string $fileSize
     */
    public function setFileSize($fileSize)
    {
        $this->file_size = $fileSize;
    }

    /**
     * Get file_size
     *
     * @return string $fileSize
     */
    public function getFileSize()
    {
        return $this->file_size;
    }

    /**
     * Set file_hash
     *
     * @param string $fileHash
     */
    public function setFileHash($fileHash)
    {
        $this->file_hash = $fileHash;
    }

    /**
     * Get file_hash
     *
     * @return string $fileHash
     */
    public function getFileHash()
    {
        return $this->file_hash;
    }

    /**
     * Set message
     *
     * @param Club\MessageBundle\Entity\Message $message
     */
    public function setMessage(\Club\MessageBundle\Entity\Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get message
     *
     * @return Club\MessageBundle\Entity\Message $message
     */
    public function getMessage()
    {
      return $this->message;
    }

    public function getAbsolutePath()
    {
      return null === $this->getFilePath() ? null : $this->getUploadRootDir().'/'.$this->getFilePath();
    }

    public function getWebPath()
    {
      return null === $this->getFilePath() ? null : $this->getUploadDir().'/'.$this->getFilePath();
    }

    protected function getUploadRootDir()
    {
      // the absolute directory path where uploaded documents should be saved
      return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
      // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
      return 'uploads/attachments';
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      $this->setFilePath(uniqid().'.'.$this->file->guessExtension());
      $this->setFileName($this->file->getClientOriginalName());
      $this->setFileSize(filesize($this->file->getPathName()));
      $this->setFileHash(hash_file('sha256', $this->file->getPathName()));

      $finfo = new \finfo(FILEINFO_MIME);
      $this->setFileType($finfo->file($this->file->getPathName()));
    }

    /**
     * @ORM\PostPersist()
     */
    public function postPersist()
    {
      $this->file->move($this->getUploadRootDir(), $this->getFilePath());
      unset($this->file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function postRemove()
    {
      if ($file = $this->getAbsolutePath()) {
        unlink($file);
      }
    }
}
