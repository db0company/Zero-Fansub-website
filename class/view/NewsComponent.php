<?php
/*
	A news is a block of text giving actual information. A news contains the text
	to display and some added data (image, author, date of writing, ...).
*/
class NewsComponent extends SimpleBlockComponent {
	public function __construct(News $news) {
		$this->setClass("news");
		
		$title = new Title($news->getTitle(), 2);
		$title->setClass("title");
		$this->addComponent($title);
		
		$subtitle = new Title(null, 4);
		$subtitle->setClass("subtitle");
		$time = "Pr�par�e";
		$timestamp = $news->getTimestamp();
		if ($timestamp !== null) {
			$time = strftime("%d/%m/%Y", $timestamp);
		}
		$subtitle->addComponent($time);
		if ($news->getAuthor() != null) {
			$subtitle->addComponent(" par ".$news->getAuthor());
		}
		$this->addComponent($subtitle);
		
		$message = new SimpleTextComponent(Format::convertTextToHtml($news->getMessage()));
		$message->setClass("message");
		$message->setContentPinned(true);
		$this->addComponent($message);
		
		// TODO group releases by projects
		if (/*$timestamp >= strtotime('12 March 2012 14:47') &&*/ $news->isReleasing()) {
			$content = '';
			$releases = array();
			foreach($news->getReleasing() as $release) {
				if ($release instanceof Project) {
					$pid = $release->getID();
					$content .= '[project='.$pid.']'.$release->getName().'[/project]';
				} else if ($release instanceof Release) {
					$pid = $release->getProject()->getID();
					$id = $release->getID();
					$content .= '[release='.$pid.'|'.$id.']'.$release->getCompleteName().'[/release]';
				} else {
					throw new Exception($release." is not a release nor a project.");
				}
				$content .= "\n";
			}
			
			$releasing = new SimpleTextComponent(Format::convertTextToHtml($content));
			$releasing->setLegend('Sorties');
			$releasing->setClass("releases");
			$this->addComponent($releasing);
		}
		
		$commentId = $news->getCommentID();
		if ($commentId !== null) {
			$commentAccess = new SimpleTextComponent();
			$commentAccess->setClass("comment");
			$commentAccess->addComponent("~ ");
			$commentAccess->addComponent(Link::newWindowLink(new Url("http://commentaires.zerofansub.net/t".$commentId.".htm"), "Commentaires"));
			$commentAccess->addComponent(" - ");
			$commentAccess->addComponent(Link::newWindowLink(new Url("http://commentaires.zerofansub.net/posting.php?mode=reply&t=".$commentId), "Ajouter un commentaire"));
			$commentAccess->addComponent(" ~");
			$this->addComponent($commentAccess);
		}
		
		$this->addComponent("~ ");
		$twitterTitle = $news->getTwitterTitle();
		if ($twitterTitle == null) {
			$twitterTitle = "[Zero] ".$news->getTitle();
		}
		$twitterUrl = Link::newWindowLink("http://twitter.com/home?status=".$twitterTitle, "Partager sur <img src='images/autre/logo_twitter.png' border='0' alt='twitter' />");
		$twitterUrl->setOnClick("javascript:pageTracker._trackPageview ('/outbound/twitter.com');");
		$this->addComponent($twitterUrl);
		$this->addComponent(" ou ");
		$this->addComponent("<a name='fb_share' type='button' share_url='http://zerofansub.net'></a>");
		$this->addComponent("<script src='http://static.ak.fbcdn.net/connect.php/js/FB.Share' type='text/javascript'></script>");
		$this->addComponent(" ~");
	}
}
?>