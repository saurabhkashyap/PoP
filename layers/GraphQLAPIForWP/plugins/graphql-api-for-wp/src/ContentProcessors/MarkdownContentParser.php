<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\ContentProcessors;

use GraphQLAPI\MarkdownConvertor\MarkdownConvertorInterface;
use Symfony\Contracts\Service\Attribute\Required;

class MarkdownContentParser extends AbstractContentParser implements MarkdownContentParserInterface
{
    protected ?MarkdownConvertorInterface $markdownConvertorInterface = null;

    public function setMarkdownConvertor(MarkdownConvertorInterface $markdownConvertorInterface): void
    {
        $this->markdownConvertorInterface = $markdownConvertorInterface;
    }
    protected function getMarkdownConvertor(): MarkdownConvertorInterface
    {
        return $this->markdownConvertorInterface ??= $this->getInstanceManager()->getInstance(MarkdownConvertorInterface::class);
    }

    //#[Required]
    final public function autowireMarkdownContentParser(
        MarkdownConvertorInterface $markdownConvertorInterface,
    ): void {
        $this->markdownConvertorInterface = $markdownConvertorInterface;
    }

    /**
     * Parse the file's Markdown into HTML Content
     */
    protected function getHTMLContent(string $fileContent): string
    {
        return $this->convertMarkdownToHTML($fileContent);
    }

    /**
     * Parse the file's Markdown into HTML Content
     */
    public function convertMarkdownToHTML(string $markdownContent): string
    {
        return $this->getMarkdownConvertorInterface()->convertMarkdownToHTML($markdownContent);
    }
}
